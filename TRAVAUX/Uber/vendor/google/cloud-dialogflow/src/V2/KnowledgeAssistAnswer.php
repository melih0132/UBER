<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/participant.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a Knowledge Assist answer.
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.KnowledgeAssistAnswer</code>
 */
class KnowledgeAssistAnswer extends \Google\Protobuf\Internal\Message
{
    /**
     * The query suggested based on the context. Suggestion is made only if it
     * is different from the previous suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.SuggestedQuery suggested_query = 1;</code>
     */
    private $suggested_query = null;
    /**
     * The answer generated for the suggested query. Whether or not an answer is
     * generated depends on how confident we are about the generated query.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.KnowledgeAnswer suggested_query_answer = 2;</code>
     */
    private $suggested_query_answer = null;
    /**
     * The name of the answer record.
     * Format: `projects/<Project ID>/locations/<location ID>/answer
     * Records/<Answer Record ID>`.
     *
     * Generated from protobuf field <code>string answer_record = 3;</code>
     */
    private $answer_record = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\SuggestedQuery $suggested_query
     *           The query suggested based on the context. Suggestion is made only if it
     *           is different from the previous suggestion.
     *     @type \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\KnowledgeAnswer $suggested_query_answer
     *           The answer generated for the suggested query. Whether or not an answer is
     *           generated depends on how confident we are about the generated query.
     *     @type string $answer_record
     *           The name of the answer record.
     *           Format: `projects/<Project ID>/locations/<location ID>/answer
     *           Records/<Answer Record ID>`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Participant::initOnce();
        parent::__construct($data);
    }

    /**
     * The query suggested based on the context. Suggestion is made only if it
     * is different from the previous suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.SuggestedQuery suggested_query = 1;</code>
     * @return \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\SuggestedQuery|null
     */
    public function getSuggestedQuery()
    {
        return $this->suggested_query;
    }

    public function hasSuggestedQuery()
    {
        return isset($this->suggested_query);
    }

    public function clearSuggestedQuery()
    {
        unset($this->suggested_query);
    }

    /**
     * The query suggested based on the context. Suggestion is made only if it
     * is different from the previous suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.SuggestedQuery suggested_query = 1;</code>
     * @param \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\SuggestedQuery $var
     * @return $this
     */
    public function setSuggestedQuery($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\SuggestedQuery::class);
        $this->suggested_query = $var;

        return $this;
    }

    /**
     * The answer generated for the suggested query. Whether or not an answer is
     * generated depends on how confident we are about the generated query.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.KnowledgeAnswer suggested_query_answer = 2;</code>
     * @return \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\KnowledgeAnswer|null
     */
    public function getSuggestedQueryAnswer()
    {
        return $this->suggested_query_answer;
    }

    public function hasSuggestedQueryAnswer()
    {
        return isset($this->suggested_query_answer);
    }

    public function clearSuggestedQueryAnswer()
    {
        unset($this->suggested_query_answer);
    }

    /**
     * The answer generated for the suggested query. Whether or not an answer is
     * generated depends on how confident we are about the generated query.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer.KnowledgeAnswer suggested_query_answer = 2;</code>
     * @param \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\KnowledgeAnswer $var
     * @return $this
     */
    public function setSuggestedQueryAnswer($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer\KnowledgeAnswer::class);
        $this->suggested_query_answer = $var;

        return $this;
    }

    /**
     * The name of the answer record.
     * Format: `projects/<Project ID>/locations/<location ID>/answer
     * Records/<Answer Record ID>`.
     *
     * Generated from protobuf field <code>string answer_record = 3;</code>
     * @return string
     */
    public function getAnswerRecord()
    {
        return $this->answer_record;
    }

    /**
     * The name of the answer record.
     * Format: `projects/<Project ID>/locations/<location ID>/answer
     * Records/<Answer Record ID>`.
     *
     * Generated from protobuf field <code>string answer_record = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAnswerRecord($var)
    {
        GPBUtil::checkString($var, True);
        $this->answer_record = $var;

        return $this;
    }

}
