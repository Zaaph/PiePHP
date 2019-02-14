<header class="row">
    <div class="col-sm-3">
        <a href="index.php" id="logo"><img src="http://via.placeholder.com/320x150" alt="logo"></a>
    </div>
    <div class="col-sm-3">
        <a href="/"></a>
    </div>
    <div class="col-sm-3">
        
    </div>
    <div class="col-sm-3">
        
    </div>
</header>
<div class="container">
    <h2>Bienvenue sur votre page!</h2>
    <div class="col-sm-4">
        <p>Email :<?= $_SESSION["email"];?></p>
    </div>
    <div class="col-sm-4">
        <p>Mot de passe:<?= $_SESSION["password"];?></p>
    </div>
    <form method="post" action="user/modify">
        <input class="btn btn-success" type="submit" name="modify" value="Modifier mes informations">
    </form>
    <form method="post" action="user/deconnect">
        <input class="btn btn-warning" type="submit" name="deconnect" value="Me déconnecter">
    </form>
    <form method="post" action="user/delete">
        <input class="btn btn-danger" id="delete" type="submit" name="delete" value="Supprimer mon compte">
    </form>
</div>
<script type="text/javascript">
    var del = document.getElementById("delete");
    del.onclick = function (event) {
        if (!confirm("Etes vous sur de vouloir supprimer votre compte?")) {
            event.preventDefault();
        }
    };
</script>