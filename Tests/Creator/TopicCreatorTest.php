<?php

namespace Herzult\ForumBundle\Creator;

class TopicCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $topic = $this->getMockBuilder('Herzult\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();

        $category = $this->getMockBuilder('Herzult\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();
        $category->expects($this->once())
            ->method('incrementNumTopics');
        $category->expects($this->once())
            ->method('setLastTopic')
            ->with($topic);

        $topic->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($category));

        $creator = new TopicCreator();
        $creator->create($topic);
    }
}
