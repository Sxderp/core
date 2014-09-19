@extends('fluxbb::layout.main')

@section('main')

<?php $post_count = 0; ?>

<div id="brdtop">
    <div class="inbox clearfix">
        <ul class="breadcrumb">
            <li><a href="{{ $route('index') }}">Index</a></li>
            <li><strong><a href="{{ $route('viewforum', $topic->forum) }}">{{{ $topic->forum->forum_name }}}</a></strong></li>
            <li><strong><a href="{{ $route('viewtopic', $topic) }}">{{{ $topic->subject }}}</a></strong></li>
        </ul>
    </div>
</div>

<div id="vt" class="vtx">

    <h2 class="topic-title"><span>{{ $topic->subject }}</span></h2>

    <div class="top-navigation clearfix">
        <ul class="pagination pagelink pull-left">
            <li class="disabled"><a><span class="pages-label">Pages: </span></a></li>
            <li class="disabled"><a><strong class="item1">1</strong></a></li>
            <li><a href="viewforum.html">2</a></li>
        </ul>
        <div class="btn-group postlink pull-right">
            @if (\FluxBB\Models\User::current()->isSubscribed($topic))
            <form action="{{ $route('topic_unsubscribe', $topic) }}" method="post">
                <input class="btn btn-default unsubscribe" type="submit" value="Unsubscribe" />
            </form>
            @else
            <form action="{{ $route('topic_subscribe', $topic) }}" method="post">
                <input class="btn btn-default subscribe" type="submit" value="Subscribe" />
            </form>
            @endif
        </div>
    </div>

@foreach ($topic->posts as $post)
    <div id="p{{ $post->id }}" class="post post-bg clearfix">
        <div class="author-box col-md-2 col-sm-2 col-xs-2">
            <div class="author-name"><h4><a href="{{ $route('profile', array('id' => $post->author->id)) }}">{{{ $post->author->username }}}</a></h4></div>
            <div class="author-title"><h5>{{{ $post->author->title() }}}</h5></div>
            <div class="author-avatar"><img src="assets/img/cyrano.jpg" width="70" height="80" alt=""></div>
            <div class="author-icon author-location"><a href="#" class="tip author-field" data-original-title="Location: Bergerac"></a></div>
            <div class="author-icon author-registered"><a href="#" class="tip author-field" data-original-title="Member since: 1619-03-06"></a></div>
            <div class="author-icon author-posts"><a href="#" class="tip author-field" data-original-title="4,815 Posts"></a></div>
            <div class="author-icon author-ip"><a href="#" class="tip author-field" data-original-title="IP: 127.0.0.1"></a></div>
            <div class="author-icon author-email"><a href="#" class="tip author-field" data-original-title="Email: "></a></div>
            <div class="author-icon author-website"><a href="#" class="tip author-field" data-original-title="Website: " rel="nofollow"></a></div>
        </div>
        <div class="post-box col-md-10 col-sm-10 col-xs-10">
            <div class="post-meta clearfix">
                <div class="pull-left">
                    <a href="{{ $route('viewpost', array('id' => $post->id)) }}#p{{ $post->id }}">{{ $post->posted }}</a>
                </div>
                <div class="pull-right">#7</div>
            </div>
            <div class="post-content">
                <p>{{ $post->message() }}</p>
            </div>
            <div class="post-footer">
                @if ($post->author->hasSignature())
                <div class="post-signature pull-left col-md-10 col-md-10 col-xs-10">
                    <p><em>{{ $post->author->signature() }}</em></p>
                </div>
                @endif
                <div class="post-menu pull-right col-md-2 col-sm-2 col-xs-2">
                    <a href="{{ $route('post_report', array('id' => $post->id)) }}" class="tip btn post-report" data-placement="top" title="Report this post" data-original-title="Report this post"></a>
                    <a href="{{ $route('post_delete', array('id' => $post->id)) }}" class="tip btn post-delete" data-placement="top" title="" data-original-title="Delete this post"></a>
                    <a href="{{ $route('post_quote', array('id' => $post->id)) }}" class="tip btn post-quote" data-placement="top" title="" data-original-title="Quote this post"></a>
                </div>
            </div>
        </div>
    </div>

@endforeach

    <div id="brdbottom">
        <div class="inbox">
            <div class="pagepost clearfix">
                <ul class="pagination pagelink pull-left">
                    <li class="disabled"><a><span class="pages-label">Pages: </span></a></li>
                    <li class="disabled"><a><strong class="item1">1</strong></a></li>
                    <li><a href="viewforum.html">2</a></li>
                </ul>
                <div class="btn-group postlink pull-right">
                    @if (\FluxBB\Models\User::current()->isSubscribed($topic))
                    <form action="{{ $route('topic_unsubscribe', $topic) }}" method="post">
                        <input class="btn btn-default unsubscribe" type="submit" value="Unsubscribe" />
                    </form>
                    @else
                    <form action="{{ $route('topic_subscribe', $topic) }}" method="post">
                        <input class="btn btn-default subscribe" type="submit" value="Subscribe" />
                    </form>
                    @endif
                </div>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ $route('index') }}">Index</a></li>
                <li><strong><a href="{{ $route('viewforum', $topic->forum) }}">{{{ $topic->forum->forum_name }}}</a></strong></li>
                <li><strong><a href="{{ $route('viewtopic', $topic) }}">{{{ $topic->subject }}}</a></strong></li>
            </ul>
        </div>
    </div>

</div>

<div id="quickpost" class="post post-bg clearfix">
    <form action="{{ $route('reply_handler', array('id' => $topic->id)) }}" method="POST">
        <div class="author-box col-md-2 col-sm-2 col-xs-2">
            <div class="author-name"><h4>Reply</h4></div>
        </div>
        <div class="post-box col-md-10 col-sm-10 col-xs-10">
            <div class="post-content">
                <textarea name="req_message" class="new-message" rows="7" cols="75" placeholder="Write your message and submit!"></textarea>
            </div>
        </div>
        <div class="new-post-submit col-md-offset-2">
            <div class="post-options pull-left">
                <span class="label label-success">BBCode</a></span>
                <span class="label label-success">[url] tag</a></span>
                <span class="label label-danger">[img] tag</a></span>
                <span class="label label-success">Smilies</a></span>
            </div>
            <input class="btn btn-success pull-right" type="submit" value="Submit" />
        </div>
    </form>
</div>

@stop
