#!/bin/bash

# 1. Laravel 新規プロジェクト作成
composer create-project laravel/laravel mypet-admin
cd mypet-admin

# 2. パッケージ導入
composer require barryvdh/laravel-debugbar laravel/telescope spatie/laravel-permission

# 3. 認証機能（Blade版でシンプルに）
php artisan breeze:install blade
npm install && npm run dev

# 4. Telescope セットアップ
php artisan telescope:install

# 5. 初期マイグレーション
php artisan migrate

# 6. `admin`ルートファイルを作成
echo "<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });" > routes/admin.php

# 7. RouteServiceProviderにルート登録（次のコードを手動で追加）
# app/Providers/RouteServiceProvider.php 内の `boot()` に以下追加
# $this->loadRoutesFrom(base_path('routes/admin.php'));

# 8. Admin用コントローラー作成
php artisan make:controller Admin/DashboardController

# 9. ビュー作成
mkdir -p resources/views/admin
echo "<x-app-layout>
    <h1>管理画面ダッシュボード（mypet-admin）</h1>
</x-app-layout>" > resources/views/admin/dashboard.blade.php

# 10. コントローラーコードを上書き
cat <<EOF > app/Http/Controllers/Admin/DashboardController.php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
EOF

echo "✅ mypet-admin プロジェクトの初期構成が完了しました！"