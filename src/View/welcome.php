<header class="row">
    <div class="col-sm-3">
        <a href="index.php" id="logo"><img src="http://via.placeholder.com/320x150" alt="logo"></a>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-1"></div>
    <div class="col-sm-4">
        <form method="post" action="login">
            <p>Déjà inscrit ?</p>
            <input type="email" name="email" placeholder="Adresse Email">
            <input type="password" name="password" placeholder="Mot de passe">
            <input class="btn btn-success" type="submit" name="submit" value="Connexion">
        </form>
    </div>
</header>
<div class="container">
    <h1 class="col-sm-8">Bienvenue sur My Cinema!</h1>
    <h3>Inscription :</h3>
    <div class="col-sm-3">
        <form method="post" action="register">
            <p>Email :</p>
            <input class="form-group" type="text" name="email" placeholder="Adresse Email">
            <p>Mot de passe:</p>
            <input class="form-group" type="password" name="password" placeholder="Mot de passe">
            <input class="btn btn-success" type="submit" name="submit" value="S'inscrire"></input>
        </form>
    </div>
</div>