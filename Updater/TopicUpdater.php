<?php

namespace Herzult\ForumBundle\Updater;

use Herzult\ForumBundle\Model\Topic;
use Herzult\ForumBundle\Model\PostRepositoryInterface;

class TopicUpdater
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function update(Topic $topic)
    {
        $posts = $this->postRepository->findAllByTopic($topic, false);

        $topic->setNumPosts(count($posts));
        $topic->setFirstPost(reset($posts));
        $lastPost = end($posts);
        $topic->setLastPost($lastPost);
        $topic->setPulledAt($lastPost->getCreatedAt());

        foreach($posts as $index => $post) {
            $post->setNumber($index + 1);
        }
    }
}
