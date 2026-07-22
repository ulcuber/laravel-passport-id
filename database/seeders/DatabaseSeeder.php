<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    protected static ?string $password;

    public function run(): void
    {
        $tokenModel = Passport::token();
        $tokensTable = $tokenModel->getTable();

        $tokenModel->newQuery()->toBase()
            ->select([
                "{$tokensTable}.user_id",
            ])
            ->leftJoin('users', fn (JoinClause $join) => $join
                ->on('users.id', '=', "{$tokensTable}.user_id")
            )
            ->whereNotNull("{$tokensTable}.user_id")
            ->whereNull('users.id')
            ->orderBy("{$tokensTable}.id")
            ->groupBy("{$tokensTable}.user_id")
            ->chunk(50, function (Collection $tokens) {
                $usersAttributes = $tokens->map(fn (\stdClass $token) => [
                    'id' => $token->user_id,
                    'name' => 'Name',
                    'email' => 'test' . $token->user_id . '@test.test',
                    'password' => static::$password ??= Hash::make('password'),
                ]);
                User::insert($usersAttributes->all());
            });
    }
}
