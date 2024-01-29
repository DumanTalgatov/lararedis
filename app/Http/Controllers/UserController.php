<?php

namespace App\Http\Controllers;

use App\Events\RatingIncreased;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function createRanking()
    {
        // Очищаем множество ранжирования перед добавлением новых рейтингов
        Redis::del('user_ranking');

        // Добавляем пользователей в ранжирование
        User::all()->each(function ($user) {
            Redis::zadd('user_ranking', $user->score, $user->id);
        });

        // Выводим ранжирование пользователей
        $ranking = Redis::zrevrange('user_ranking', 0, -1, 'WITHSCORES');
        dd($ranking);
    }

    public function getRanking($id)
    {
        $userRating = Redis::zscore('user_ranking', $id);
        dd($userRating);
    }

    public function updateRanking($userId)
    {
        // Получение текущего рейтинга пользователя
        $userScore = Redis::zscore('user_ranking', $userId);

        // Увеличение или уменьшение рейтинга в зависимости от бизнес-логики
        $newScore = $userScore + 10; // Увеличиваем рейтинг на 10

        // Обновление рейтинга пользователя
        Redis::zadd('user_ranking', $newScore, $userId);

        // Генерируем событие RatingIncreased
        event(new RatingIncreased($userId));
    }
}
