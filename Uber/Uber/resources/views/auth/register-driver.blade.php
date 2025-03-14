@extends('layouts.app')

@section('title', 'Inscription Coursier')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.blade.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/js.js') }}"></script>
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Inscription Coursier</h1>

        <form action="{{ route('register') }}" method="POST" class="form-register">
            @csrf

            <!-- Informations personnelles -->
            <div class="form-section">
                <h5>Informations personnelles</h5>

                <div class="form-group">
                    <label for="nomuser">Nom :</label>
                    <input type="text" name="nomuser" id="nomuser" class="form-control" required maxlength="50"
                        placeholder="Votre nom">
                </div>

                <div class="form-group">
                    <label for="prenomuser">Prénom :</label>
                    <input type="text" name="prenomuser" id="prenomuser" class="form-control" required maxlength="50"
                        placeholder="Votre prénom">
                </div>

                <div class="form-group">
                    <label for="genreuser">Genre :</label>
                    <select name="genreuser" id="genreuser" class="form-control" required>
                        <option value="" disabled selected>Choisissez votre genre</option>
                        <option value="Monsieur">Monsieur</option>
                        <option value="Madame">Madame</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="datenaissance">Date de naissance :</label>
                    <input type="date" name="datenaissance" id="datenaissance" class="form-control" required>
                    <small>Vous devez avoir au moins 18 ans.</small>
                </div>
            </div>

            <!-- Coordonnées personnelles -->
            <div class="form-section">
                <h5>Coordonnées personnelles</h5>

                <div class="form-group">
                    <label for="telephone">Téléphone :</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" required
                        pattern="^(06|07)[0-9]{8}$|^\+?[1-9][0-9]{1,14}$"
                        title="Numéro de téléphone valide (06 ou 07 suivi de 8 chiffres ou format international)"
                        placeholder="06XXXXXXXX" inputmode="tel" oninput="validatePhoneNumberInput(this)">
                    <small>Exemple : 0612345678 ou +33123456789</small>
                </div>

                <div class="form-group">
                    <label for="emailuser">Email :</label>
                    <input type="email" name="emailuser" id="emailuser" class="form-control" required
                        placeholder="exemple@mail.com">
                </div>

                <div class="form-group">
                    <label for="libelleadresse">Adresse :</label>
                    <input type="text" name="libelleadresse" id="libelleadresse" class="form-control" required
                        maxlength="100" placeholder="Votre adresse">
                </div>

                <div class="form-group">
                    <label for="nomville">Ville :</label>
                    <input type="text" name="nomville" id="nomville" class="form-control" required maxlength="50"
                        placeholder="Votre ville">
                </div>

                <div class="form-group">
                    <label for="codepostal">Code Postal :</label>
                    <input type="text" name="codepostal" id="codepostal" class="form-control" required pattern="^\d{5}$"
                        title="Code postal valide (5 chiffres)" placeholder="75000" maxlength="5"
                        oninput="validateNumericInput(this)">
                    <small>Format : 5 chiffres (exemple : 75000).</small>
                </div>
            </div>

            <!-- Section Sécurité -->
            <div class="form-section">
                <h5>Sécurité</h5>

                <div class="form-group">
                    <label for="motdepasseuser">Mot de passe :</label>
                    <input type="password" id="motdepasseuser" name="motdepasseuser" class="form-control" required
                        minlength="8" placeholder="Saisissez un mot de passe sécurisé" oninput="checkPasswordStrength()">
                    <small>Votre mot de passe doit contenir au moins :</small>

                    <ul class="password-requirements">
                        <li><input type="checkbox" id="lengthCheck" disabled> 8 caractères minimum</li>
                        <li><input type="checkbox" id="uppercaseCheck" disabled> Une majuscule</li>
                        <li><input type="checkbox" id="numberCheck" disabled> Un chiffre</li>
                        <li><input type="checkbox" id="specialCharCheck" disabled> Un caractère spécial (;!?$#)</li>
                    </ul>

                    <div id="password-strength" class="mt-2"></div>
                </div>

                <div class="form-group">
                    <label for="motdepasseuser_confirmation">Confirmation du mot de passe :</label>
                    <input type="password" name="motdepasseuser_confirmation" id="motdepasseuser_confirmation"
                        class="form-control" required placeholder="Confirmez votre mot de passe">
                </div>
            </div>

            <!-- Carte VTC -->
            <div class="form-section">
                <h5>Carte VTC</h5>

                <div class="form-group">
                    <label for="numerocartevtc">Numéro de carte VTC :</label>
                    <input type="text" name="numerocartevtc" id="numerocartevtc" class="form-control" required
                        pattern="^\d{12}$" title="Numéro VTC valide (12 chiffres)" placeholder="123456789012"
                        maxlength="12" inputmode="numeric" oninput="validateNumericInput(this)">
                    <small>Veuillez entrer exactement 12 chiffres.</small>
                </div>
            </div>

            <!-- Informations sur l'entreprise -->
            <div class="form-section">
                <h5>Informations sur votre entreprise</h5>

                <div class="form-group">
                    <label for="nomentreprise">Nom de l'entreprise :</label>
                    <input type="text" name="nomentreprise" id="nomentreprise" class="form-control" required
                        maxlength="100" placeholder="Nom de l'entreprise">
                </div>

                <div class="form-group">
                    <label for="siretentreprise">SIRET de l'entreprise :</label>
                    <input type="text" name="siretentreprise" id="siretentreprise" class="form-control" required
                        pattern="^\d{14}$" title="SIRET valide (14 chiffres)" placeholder="12345678901234"
                        maxlength="14" inputmode="numeric" oninput="validateNumericInput(this)">
                    <small>Veuillez entrer exactement 14 chiffres.</small>
                </div>

                <div class="form-group">
                    <label for="taille">Taille de l'entreprise :</label>
                    <select name="taille" id="taille" class="form-control" required>
                        <option value="" disabled selected>Choisissez une taille</option>
                        <option value="PME">PME</option>
                        <option value="ETI">ETI</option>
                        <option value="GE">GE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="adresseEntreprise">Adresse de l'entreprise :</label>
                    <input type="text" name="adresseEntreprise" id="adresseEntreprise" class="form-control" required
                        maxlength="100" placeholder="Adresse complète">
                </div>

                <div class="form-group">
                    <label for="villeEntreprise">Ville de l'entreprise :</label>
                    <input type="text" name="villeEntreprise" id="villeEntreprise" class="form-control" required
                        maxlength="50" placeholder="Ville">
                </div>

                <div class="form-group">
                    <label for="codepostalEntreprise">Code Postal de l'entreprise :</label>
                    <input type="text" name="codepostalEntreprise" id="codepostalEntreprise" class="form-control"
                        required pattern="^\d{5}$" title="Code postal valide (5 chiffres)" placeholder="75000"
                        maxlength="5" oninput="validateNumericInput(this)">
                    <small>Format : 5 chiffres (exemple : 75000).</small>
                </div>
            </div>

            <div class="form-group">
                <label for="consentement_cgu">
                    En créant un compte Uber, vous acceptez les <a href="{{ route('cgu') }}" target="_blank">conditions
                        générales d'utilisation</a>
                    et la
                    <a href="{{ route('privacy') }}" target="_blank">politique de confidentialité</a>.
                </label>
            </div>

            <!-- Notifications -->
            @if (session('success') || session('error'))
                <div class="alert-message @if (session('success')) success @elseif(session('error')) error @endif"
                    role="alert">
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <!-- Actions -->
            <input type="hidden" name="role" value="coursier">

            <button type="submit" id="registerBtn" class="btn-login mt-2" disabled>S'inscrire</button>
        </form>
    </div>
@endsection
