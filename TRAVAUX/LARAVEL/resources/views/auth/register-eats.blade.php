@extends('layouts.app')

@section('title', 'Inscription')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.blade.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Inscription</h1>
        <form action="{{ route('register') }}" method="POST" class="form-register d-flex flex-column justify-content-center">
            @csrf
            <input type="hidden" name="role" value="client">

            <div class="form-group">
                <label for="nomuser">Nom :</label>
                <input type="text" name="nomuser" id="nomuser" class="form-control" required maxlength="50">
            </div>

            <div class="form-group">
                <label for="prenomuser">Prénom :</label>
                <input type="text" name="prenomuser" id="prenomuser" class="form-control" required maxlength="50">
            </div>

            <label for="genreuser">Genre :</label>
            <select name="genreuser" id="genreuser" required>
                <option value="Monsieur">Monsieur</option>
                <option value="Madame">Madame</option>
            </select>

            <label for="datenaissance">Date de naissance :</label>
            <input type="date" name="datenaissance" id="datenaissance" required>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" name="telephone" id="telephone" class="form-control" required
                    pattern="^(06|07)[0-9]{8}$" title="Numéro de téléphone valide (06 ou 07 suivi de 8 chiffres)">
            </div>

            <div class="form-group">
                <label for="emailuser">Email :</label>
                <input type="email" name="emailuser" id="emailuser" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="motdepasseuser">Mot de passe :</label>
                <input type="password" id="motdepasseuser" name="motdepasseuser" class="form-control" required
                    minlength="8" oninput="checkPasswordStrength()">
                <div id="password-strength" style="margin-top: 5px; font-weight: bold;"></div>
            </div>

            <div class="form-group">
                <label for="motdepasseuser_confirmation">Confirmation du mot de passe :</label>
                <input type="password" name="motdepasseuser_confirmation" id="motdepasseuser_confirmation"
                    class="form-control" required>
            </div>

            <div class="d-inline-flex align-items-center my-3" id="bonPlanFields">
                <label>Souhaitez-vous recevoir des bons plans ?</label>
                <input class="check-box mx-2" type="checkbox" name="souhaiterecevoirbonplan" id="souhaiterecevoirbonplan"
                    value="1">
            </div>

            <div class="form-group">
                <label for="libelleadresse">Adresse :</label>
                <input type="text" name="libelleadresse" id="libelleadresse" class="form-control" required
                    maxlength="100">
            </div>

            <div class="form-group">
                <label for="nomville">Ville :</label>
                <input type="text" name="nomville" id="nomville" class="form-control" required maxlength="50">
            </div>

            <div class="form-group">
                <label for="codepostal">Code Postal :</label>
                <input type="text" name="codepostal" id="codepostal" class="form-control"
                    title="Code postal valide (5 chiffres)" required>
            </div>

            <button type="submit" class="btn-login">S'inscrire</button>
        </form>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('motdepasseuser').value;
            const strengthDisplay = document.getElementById('password-strength');
            let strength = '';
            let color = '';

            const hasLowerCase = /[a-z]/.test(password);
            const hasUpperCase = /[A-Z]/.test(password);
            const hasNumbers = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#\$%\^&\*]/.test(password);
            const uniqueChars = new Set(password).size;

            if (password.length < 8 || uniqueChars <= 3) {
                strength = 'Faible';
                color = 'red';
            } else if (password.length >= 8 && uniqueChars > 3 &&
                (hasLowerCase || hasUpperCase || hasNumbers || hasSpecialChar)) {
                strength = 'Moyen';
                color = 'orange';

                if (password.length > 10 && hasLowerCase && hasUpperCase &&
                    hasNumbers && hasSpecialChar && uniqueChars > 6) {
                    strength = 'Fort';
                    color = 'green';
                }
            } else {
                strength = 'Très Faible';
                color = 'darkred';
            }

            strengthDisplay.textContent = `Force du mot de passe : ${strength}`;
            strengthDisplay.style.color = color;
        }
    </script>
@endsection