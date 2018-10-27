<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Backbone JS - Simple Blog</title>
    <link rel="icon" href="/assets/images/favicon.png">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/css/normalize.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/custom.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css">

    <script src="/assets/js/lib/modernizr-2.6.2.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Simple Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor03">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/posts/index">Index <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/posts/create">Create</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h2>Create a post</h2>
            <br />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <?php
            if($model->hasErrors()) {
                $errors = $model->getErrors();
                $dirPath = realpath(dirname(dirname(__FILE__)));
                include_once "{$dirPath}/post/errors.php";
            }
           ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="form-group" action="/posts/create" method="post">
                <div class="form-group">
                    <label class="form-control-label" for="title">Title</label>
                    <input type="text" name="title" placeholder="Type title of the post" class="form-control is-valid" id="title" value="<?=$model->title?>">
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="description">Description</label>
                    <textarea rows="8" cols="50" name="description" placeholder="Type description" class="form-control is-valid" id="author" > <?=$model->description?> </textarea>
                </div>

                <br />
                <button type="submit" class="btn btn-outline-secondary">Add</button>
            </form>
        </div>
    </div>


</div>

<script src="/assets/js/lib/jquery-min.js"></script>
<script src="/assets/js/lib/bootstrap.js"></script>

</body>
</html>
