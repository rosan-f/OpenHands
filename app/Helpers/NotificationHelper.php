<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;

class NotificationHelper
{
 
    public static function createDonationNotification($donation)
    {
        $post = $donation->post;
        $donor = $donation->user;

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'donation',
            'title' => 'Donasi Baru!',
            'message' => ($donation->is_anonymous ? 'Seseorang' : $donor->name) . ' baru saja mendonasikan Rp ' . number_format($donation->amount, 0, ',', '.') . ' untuk kampanye Anda',
            'action_url' => route('posts.show', $post->id),
            'related_user_id' => $donation->is_anonymous ? null : $donor->id,
            'related_post_id' => $post->id,
        ]);
    }


    public static function createLikeNotification($like)
    {
        $post = $like->post;
        $liker = $like->user;


        if ($post->user_id === $liker->id) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'like',
            'title' => 'Suka Baru!',
            'message' => $liker->name . ' menyukai kampanye Anda',
            'action_url' => route('posts.show', $post->id),
            'related_user_id' => $liker->id,
            'related_post_id' => $post->id,
        ]);
    }


    public static function createCommentNotification($comment)
    {
        $post = $comment->post;
        $commenter = $comment->user;

        if ($post->user_id === $commenter->id) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'comment',
            'title' => 'Komentar Baru!',
            'message' => $commenter->name . ' berkomentar pada kampanye Anda',
            'action_url' => route('posts.show', $post->id) . '#comments',
            'related_user_id' => $commenter->id,
            'related_post_id' => $post->id,
        ]);
    }


    public static function createGoalReachedNotification($post)
    {
        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'goal_reached',
            'title' => 'Target Tercapai! ',
            'message' => 'Selamat Kampanye "' . $post->title . '" telah mencapai target donasi',
            'action_url' => route('posts.show', $post->id),
            'related_post_id' => $post->id,
        ]);
    }


}
