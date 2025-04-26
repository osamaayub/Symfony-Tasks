<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $postsData = [
            [
                'ref' => 'post-1',
                'title' => 'Travelling',
                'content' => 'Travelling to countries like Germany is a great experience.',
                'author' => 'Nomadic Matt',
            ],
            [
                'ref' => 'post-2',
                'title' => 'Cooking',
                'content' => 'Cooking is a valuable skill everyone should learn.',
                'author' => 'Chef John',
            ],
        ];

        foreach ($postsData as $postData) {
            $post = new Post();
            $post->setTitle($postData['title']);
            $post->setContent($postData['content']);
            $post->setAuthor($postData['author']);

            $manager->persist($post);

            // Save a reference for use in CommentFixtures
            $this->addReference($postData['ref'], $post);
        }

        $manager->flush();
    }
}
?>