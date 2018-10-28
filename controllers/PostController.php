<?php
namespace App\Controllers;


class PostController extends Controller
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Returns the index page
     */
    public function index()
    {
        $this->render('index', []);
    }

    /**
     * Returns the form page for new post entry
     * It the HTTP request is a post then it save it to DB
     * And redirects to index page
     */
    public function create()
    {
        $post = new \App\Models\Post();

        if($this->request->isPost()) {
            $post->setAttributes($this->request);
            if( $post->validate() && $post->create() ) {
                header("Location: /posts/index");
            }
        }

        $this->render('create', $post);
    }

    /**
     * Updates the model
     * On success redirects to index page
     * For ajax call
     */
    public function update()
    {
        $post = new \App\Models\Post();

        $post->setAttributes($this->request);
        if( $post->validate() && $post->update() ) {
            return ['status' => 'success'];
        }

        return ['status' => $post->getErrors()];
    }

    /**
     * Deletes a post
     * The id of the post exists in the params attribute of request object
     * For ajax call
     */
    public function delete()
    {
        $post = new \App\Models\Post();

        $post->setAttributes($this->request);
        if( $post->delete() ) {
           return ['status' => 'success'];
        }

        return ['status' => 'cannot delete'];
    }



    /**
     * This returns the index page's data only (no html )
     * @return mixed
     */
    public function indexJson()
    {
        $post = new \App\Models\Post();
        $posts = $post->readAll();
        return $posts;
    }
}
