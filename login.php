<!DOCTYPE html>
<html lang="en">

<?php require_once "template_header.php"; ?>

<body class="bg-light">
    <form id="form-login" class="text-center shadow-sm p-3 rounded bg-white w-100"
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 360px;">
        <h2 class="mb-3 border-bottom border-2 border-dark py-2">Login</h2>

        <div class="d-flex flex-column gap-2">
            <div class="form-floating">
                <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username"
                    required>
                <label for="inputUsername">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password"
                    required>
                <label for="inputPassword">Password</label>
            </div>
        </div>

        <button type="submit" class="w-100 btn btn-lg btn-outline-success mt-2">Login</button>
    </form>

    <script>
    $("#form-login").submit((e) => {
        e.preventDefault();
        const username = $("#inputUsername").val();
        const password = $("#inputPassword").val();

        if (username == "" || password == "") {
            alert("Username or password field is empty")
            return;
        }

        $.ajax({
            url: "<?= DIR_APP ?>/api/auth/login.php",
            data: {
                username,
                password
            },
            method: "POST",
            success: () => {
                window.location.replace("<?= DIR_APP ?>/");
            }
        })
    })
    </script>
</body>

</html>