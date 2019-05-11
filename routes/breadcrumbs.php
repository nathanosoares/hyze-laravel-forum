<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Início', route('home'));
});

// Home > Chatter
Breadcrumbs::for('chatter', function ($trail) {
    $trail->parent('home');
    $trail->push('Comunidade', route('chatter.home'), []);
});

// Home > Chatter > [Category]
Breadcrumbs::for('chatter.category', function ($trail, $category) {
    $trail->parent('chatter');

    $trail->push($category->name, route('chatter.home', sprintf('#%s.%s', $category->slug, $category->id)));
});


// Home > Chatter > [Category] > [Forum]
Breadcrumbs::for('chatter.forum', function ($trail, $forum) {
    $trail->parent('chatter.category', $forum->category);

    if ($forum->parent) {
        $trail->push($forum->parent->name, route('chatter.forum', [$forum->parent->slug, $forum->parent->id]));
    }

    $trail->push($forum->name, route('chatter.forum', [$forum->slug, $forum->id]));
});

// Home > Chatter > [Category] > [Forum] > [Thread]
Breadcrumbs::for('chatter.thread', function ($trail, $thread) {
    $trail->parent('chatter.forum', $thread->forum);

    $trail->push($thread->title, thread_url($thread));
});
