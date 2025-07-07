# プロジェクトセットアップ手順

このドキュメントでは、プロジェクトのセットアップ手順を日本語で説明します。

---

## 必要条件

- PHP 8.0 以上
- Composer
- SQLite または MySQL データベース
- Laravel フレームワーク

---

## セットアップ手順

### 1. リポジトリのクローン
まず、プロジェクトのリポジトリをクローンします。

```bash
git clone <リポジトリのURL>
cd mypet-admin
```

---

### 2. 依存関係のインストール
Composer を使用して依存関係をインストールします。

```bash
composer install
```

---

### 3. 環境ファイルの設定
`.env` ファイルを作成し、必要な環境変数を設定します。

```bash
cp .env.example .env
```

データベース設定を以下のように編集します（SQLite を使用する場合の例）:

```env
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite
```

---

### 4. データベースの準備
SQLite データベースファイルを作成し、マイグレーションを実行します。

```bash
touch database/database.sqlite
php artisan migrate --seed
```

---

### 5. ルートの確認
以下のコマンドでルートが正しく登録されていることを確認します。

```bash
php artisan route:list
```

---

### 6. テストの実行
プロジェクトのテストを実行して、すべてが正しく動作していることを確認します。

```bash
php artisan test
```

---

## エンドポイントの確認

以下は、主要な API エンドポイントの例です。

### ペット関連
- **すべてのペットを取得**: `GET /api/pets`
- **特定のペットを取得**: `GET /api/pets/{id}`
- **新しいペットを作成**: `POST /api/pets`
- **ペット情報を更新**: `PUT /api/pets/{id}`
- **ペットを削除**: `DELETE /api/pets/{id}`

### 健康記録関連
- **ペットの健康記録を取得**: `GET /api/pets/{id}/health-records`
- **新しい健康記録を追加**: `POST /api/pets/{id}/health-records`
- **健康記録を更新**: `PUT /api/health-records/{id}`
- **健康記録を削除**: `DELETE /api/health-records/{id}`

### 訪問記録関連
- **ペットの訪問記録を取得**: `GET /api/pets/{id}/visits`
- **新しい訪問記録を追加**: `POST /api/pets/{id}/visits`
- **訪問記録を更新**: `PUT /api/visits/{id}`
- **訪問記録を削除**: `DELETE /api/visits/{id}`

---

## トラブルシューティング

### ルートが表示されない場合
以下のコマンドでキャッシュをクリアしてください。

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### データベースエラーが発生する場合
データベースをリセットして再度シードを実行してください。

```bash
php artisan migrate:fresh --seed
```

---

## Laravel 開発サーバーを起動

以下のコマンドで Laravel の開発サーバーを起動します。

```bash
php artisan serve
```

デフォルトでは、サーバーは `http://127.0.0.1:8000` で起動します。

---

## curl コマンドでエンドポイントを確認

以下のコマンドを使用して、エンドポイントが正しく動作しているか確認します。

- **すべてのペットを取得**:
  ```bash
  curl -X GET http://127.0.0.1:8000/api/pets
  ```

- **特定のペットを取得**:
  ```bash
  curl -X GET http://127.0.0.1:8000/api/pets/1
  ```

- **新しいペットを作成**:
  ```bash
  curl -X POST http://127.0.0.1:8000/api/pets \
  -H "Content-Type: application/json" \
  -d '{"name": "Buddy", "species": "Dog", "gender": "male", "weight": 12.5}'
  ```

- **ペット情報を更新**:
  ```bash
  curl -X PUT http://127.0.0.1:8000/api/pets/1 \
  -H "Content-Type: application/json" \
  -d '{"name": "Updated Buddy", "weight": 15.0}'
  ```

- **ペットを削除**:
  ```bash
  curl -X DELETE http://127.0.0.1:8000/api/pets/1
  ```

---

## ライセンス
このプロジェクトは [MIT ライセンス](https://opensource.org/licenses/MIT) の下で公開されています。