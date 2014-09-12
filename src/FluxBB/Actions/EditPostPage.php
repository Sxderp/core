<?php

namespace FluxBB\Actions;

use FluxBB\Core\Action;
use FluxBB\Models\Post;

class EditPostPage extends Action
{
    protected function run()
    {
        $pid = $this->request->get('id');

        // Fetch some info about the topic
        $post = Post::with('author', 'topic')->findOrFail($pid);

        $this->data['post'] = $post;
        $this->data['action'] = trans('fluxbb::forum.edit_post');
    }
}
