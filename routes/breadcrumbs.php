<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Início', route('home'));
});

// Home > Forums
Breadcrumbs::for('forums', function ($trail) {
    $trail->parent('home');
    $trail->push('Comunidade', route('forums.home'), []);
});

// Home > Forums > [Category]
Breadcrumbs::for('forums.category', function ($trail, $category) {
    $trail->parent('forums');

    $trail->push($category->name, route('forums.home', sprintf('#%s.%s', $category->slug, $category->id)));
});


// Home > Forums > [Category] > [Forum]
Breadcrumbs::for('forums.forum', function ($trail, $forum) {
    $trail->parent('forums.category', $forum->category);

    if ($forum->parent) {
        $trail->push($forum->parent->name, route('forums.forum', [$forum->parent->slug, $forum->parent->id]));
    }

    $trail->push($forum->name, route('forums.forum', [$forum->slug, $forum->id]));
});

// Home > Forums > [Category] > [Forum] > [Thread]
Breadcrumbs::for('forums.thread', function ($trail, $thread) {
    $trail->parent('forums.forum', $thread->forum);

    $trail->push($thread->title, thread_url($thread));
});
