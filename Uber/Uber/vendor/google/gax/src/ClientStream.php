<?php
/*
 * Copyright 2016 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore;

use Google\Auth\Logging\LoggingTrait;
use Google\Auth\Logging\RpcLogEvent;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Code;
use Grpc\ClientStreamingCall;
use Psr\Log\LoggerInterface;

/**
 * ClientStream is the response object from a gRPC client streaming API call.
 */
class ClientStream
{
    use LoggingTrait;

    private $call;
    private null|LoggerInterface $logger;

    /**
     * ClientStream constructor.
     *
     * @param ClientStreamingCall $clientStreamingCall The gRPC client streaming call object
     * @param array $streamingDescriptor
     * @param null|LoggerInterface $logger A PSR-3 compliant logger.
     */
    public function __construct(// @phpstan-ignore-line
        ClientStreamingCall $clientStreamingCall,
        array $streamingDescriptor = [],
        null|LoggerInterface $logger = null,
    ) {
        $this->call = $clientStreamingCall;
        $this->logger = $logger;
    }

    /**
     * Write request to the server.
     *
     * @param mixed $request The request to write
     */
    public function write($request)
    {
        // In some cases, $request can be a string
        if ($this->logger && $request instanceof Message) {
            $requestEvent = new RpcLogEvent();

            $requestEvent->payload = $request->serializeToJsonString();
            $requestEvent->processId = (int) getmypid();
            $requestEvent->requestId = crc32((string) spl_object_id($this) . getmypid());

            $this->logRequest($requestEvent);
        }

        $this->call->write($request);
    }

    /**
     * Read the response from the server, completing the streaming call.
     *
     * @throws ApiException
     * @return mixed The response object from the server
     */
    public function readResponse()
    {
        list($response, $status) = $this->call->wait();
        if ($status->code == Code::OK) {
            if ($this->logger) {
                $responseEvent = new RpcLogEvent();

                $responseEvent->headers = $status->metadata;
                $responseEvent->status = $status->code;
                $responseEvent->processId = (int) getmypid();
                $responseEvent->requestId = crc32((string) spl_object_id($this) . getmypid());

                if ($response instanceof Message) {
                    $response->serializeToJsonString();
                }

                $this->logResponse($responseEvent);
            }

            return $response;
        } else {
            throw ApiException::createFromStdClass($status);
        }
    }

    /**
     * Write all data in $dataArray and read the response from the server, completing the streaming
     * call.
     *
     * @param mixed[] $requests An iterator of request objects to write to the server
     * @return mixed The response object from the server
     */
    public function writeAllAndReadResponse(array $requests)
    {
        foreach ($requests as $request) {
            $this->write($request);
        }
        return $this->readResponse();
    }

    /**
     * Return the underlying gRPC call object
     *
     * @return \Grpc\ClientStreamingCall|mixed
     */
    public function getClientStreamingCall()
    {
        return $this->call;
    }
}
