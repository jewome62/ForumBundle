<?php

namespace Herzult\Bundle\ForumBundle\Templating\Helper;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\Helper\Helper;
use Herzult\Bundle\ForumBundle\Model\Category;
use Herzult\Bundle\ForumBundle\Model\Topic;
use Herzult\Bundle\ForumBundle\Model\Post;

class ForumHelper extends Helper
{
    protected $router;
    protected $nbPostsPerPage;

    public function __construct(RouterInterface $router, $nbPostsPerPage)
    {
        $this->router = $router;
        $this->nbPostsPerPage = $nbPostsPerPage;
    }

    public function urlForCategory(Category $category, $absolute = false)
    {
        return $this->router->generate('herzult_forum_category_show', array(
            'slug' => $category->getSlug()
        ), $absolute);
    }

    public function urlForCategoryAtomFeed(Category $category, $absolute = false)
    {
        return $this->router->generate('herzult_forum_category_show', array(
            'slug'      => $category->getSlug(),
            '_format'   =>  'xml'
        ), $absolute);
    }

    public function urlForTopic(Topic $topic, $absolute = false)
    {
        return $this->router->generate('forum_topic_show', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug()
        ), $absolute);
    }

    public function urlForTopicAtomFeed(Topic $topic, $absolute = false)
    {
        return $this->router->generate('forum_topic_show', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug(),
            '_format'       => 'xml'
        ), $absolute);
    }

    public function urlForTopicReply(Topic $topic, $absolute = false)
    {
        return $this->router->generate('forum_topic_post_new', array(
            'categorySlug'  => $topic->getCategory()->getSlug(),
            'slug'          => $topic->getSlug()
        ));
    }

    public function urlForPost(Post $post, $absolute = false)
    {
        $topicUrl = $this->urlForTopic($post->getTopic(), $absolute);
        $topicPage = ceil($post->getNumber() / $this->nbPostsPerPage);

        return sprintf('%s?page=%d#%d', $topicUrl, $topicPage, $post->getNumber());
    }

    public function getTopicNumPages(Topic $topic)
    {
        return ceil($topic->getNumPosts() / $this->nbPostsPerPage);
    }

    public function autoLink($text)
    {
        return preg_replace_callback('~
            (                       # leading text
                <\w+.*?>|             #   leading HTML tag, or
                [^=!:\'"/]|           #   leading punctuation, or
                ^                     #   beginning of line
            )
            (
                (?:https?://)|        # protocol spec, or
                (?:www\.)             # www.*
            )
            (
                [-\w]+                   # subdomain or domain
                (?:\.[-\w]+)*            # remaining subdomains or domain
                (?::\d+)?                # port
                (?:/(?:(?:[\~\w\+%-]|(?:[,.;:][^\s$]))+)?)* # path
                (?:\?[\w\+%&=.;-]+)?     # query string
                (?:\#[\w\-]*)?           # trailing anchor
            )
            ([[:punct:]]|\s|<|$)    # trailing text
            ~x',
            function($matches)
            {
                if (preg_match("/<a\s/i", $matches[1])) {
                    return $matches[0];
                } else {
                    return $matches[1].'<a href="'.($matches[2] == 'www.' ? 'http://www.' : $matches[2]).$matches[3].'" target="_blank">'.$matches[2].$matches[3].'</a>'.$matches[4];
                }
            },
            $text
        );
    }

    public function getName()
    {
        return 'forum';
    }

}
