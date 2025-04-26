<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $commentsData = [
            'post-1' => [
                ['author' => 'Alice', 'content' => 'I love Germany too!'],
                ['author' => 'Bob', 'content' => 'Can you recommend cities to visit?'],
            ],
            'post-2' => [
                ['author' => 'Claire', 'content' => 'What’s your favorite recipe?'],
                ['author' => 'David', 'content' => 'I just learned how to bake bread!'],
            ],
        ];

        foreach ($commentsData as $postRef => $comments) {
            /** @var Post $post */
            // adding reference to each post 
            $post = $this->getReference($postRef,Post::class);

            foreach ($comments as $commentData) {
                $comment = new Comment();
                $comment->setAuthor($commentData['author']);
                $comment->setContent($commentData['content']);
                $comment->setPost($post); // Set owning side

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixtures::class,
        ];
    }
}
?>