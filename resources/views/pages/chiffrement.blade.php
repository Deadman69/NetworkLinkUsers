@extends('layout.default')
@section('title') Chiffrement @endsection

@section('top-css')
    <style type="text/css">

    </style>
@endsection

@section('content')
    <div class="row">
        <h1 class="mb-4">AES-CBC Encryption/Decryption</h1>
        <form id="aes-form">
            <div class="mb-3">
                <label for="inputText" class="form-label">Input Text</label>
                <textarea class="form-control" id="inputText" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="keySize" class="form-label">Key Size</label>
                <select class="form-select" id="keySize">
                    <option value="128">128 bits</option>
                    <option value="256">256 bits</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="outputText" class="form-label">Output Text</label>
                <textarea class="form-control" id="outputText" rows="3" readonly></textarea>
            </div>
            <button class="btn btn-primary" id="encryptBtn">Encrypt</button>
            <button class="btn btn-primary" id="decryptBtn">Decrypt</button>
        </form>
    </div>
@endsection

@section('bottom-scripts')
    <script type="text/javascript" src="/assets/scripts/crypto-js.js"></script>
    <script type="text/javascript">
        // Fonction de chiffrement
        function encryptAES(data, key, keySize = 256) {
            const keyHex = CryptoJS.enc.Utf8.parse(key);
            const iv = CryptoJS.lib.WordArray.random(16);
            const encrypted = CryptoJS.AES.encrypt(data, keyHex, {
                iv: iv,
                keySize: keySize / 8,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            });
            const ciphertext = iv.concat(encrypted.ciphertext);
            return ciphertext.toString(CryptoJS.enc.Base64);
        }

        // Fonction de déchiffrement
        function decryptAES(ciphertext, key, keySize = 256) {
            const keyHex = CryptoJS.enc.Utf8.parse(key);
            ciphertext = CryptoJS.enc.Base64.parse(ciphertext);
            const iv = ciphertext.clone().words.splice(0, 4);
            const ivHex = CryptoJS.lib.WordArray.create(iv);
            const encrypted = ciphertext.clone().words.slice(4);
            const decrypted = CryptoJS.AES.decrypt(
                { ciphertext: CryptoJS.lib.WordArray.create(encrypted) },
                keyHex,
                {
                    iv: ivHex,
                    keySize: keySize / 8,
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7
                }
            );
            return decrypted.toString(CryptoJS.enc.Utf8);
        }

        $(document).ready(function() {
            $('#encryptBtn, #decryptBtn').click(function(e) {
                e.preventDefault();

                const inputText = $('#inputText').val();
                const password = $('#password').val();
                const keySize = $('#keySize').val();

                var output = "Error !";
                if(this.id == "encryptBtn") {
                    output = encryptAES(inputText, password, keySize);
                } else {
                    output = decryptAES(inputText, password, keySize);
                }
                $('#outputText').val(output);
            });
        });
    </script>
@endsection
