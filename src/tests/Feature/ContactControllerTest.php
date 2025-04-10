<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Channel;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $category = Category::create(['content' => 'テストカテゴリ']);
        $channel = Channel::create(['content' => 'テストチャンネル']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('contact');
        $response->assertViewHas('categories');
        $response->assertViewHas('channels');
    }

    public function test_confirm()
    {
        $category = Category::create(['content' => 'テストカテゴリ']);
        $channel1 = Channel::create(['content' => 'メール']);
        $channel2 = Channel::create(['content' => '電話']);

        $formData = [
            'first_name' => '太郎',
            'last_name' => 'テスト',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel_1' => '090',
            'tel_2' => '1234',
            'tel_3' => '5678',
            'address' => '東京都新宿区',
            'building' => 'テストビル101',
            'detail' => '問い合わせ内容の詳細です',
            'category_id' => $category->id,
            'channel_ids' => [$channel1->id, $channel2->id],
        ];

        $response = $this->post('/confirm', $formData);

        $response->assertStatus(200);
        $response->assertViewIs('confirm');

        $response->assertViewHas('contacts');
        $response->assertViewHas('category');
        $response->assertViewHas('channels');
    }

    public function test_store_thanks()
    {
        $category = Category::create(['content' => 'テストカテゴリ']);
        $channel1 = Channel::create(['content' => 'SNS']);
        $channel2 = Channel::create(['content' => '広告']);

        $formData = [
            'first_name' => '太郎',
            'last_name' => 'テスト',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel_1' => '080',
            'tel_2' => '1234',
            'tel_3' => '5678',
            'address' => '東京都',
            'building' => 'ビル101',
            'detail' => 'これはテストメッセージです',
            'category_id' => $category->id,
            'channel_ids' => [$channel1->id, $channel2->id],
            'image_file' => 'img/test.jpg',
        ];

        $response = $this->post('/thanks', $formData);

        $response->assertStatus(200);
        $response->assertViewIs('thanks');

        $this->assertDatabaseHas('contacts', [
            'first_name' => '太郎',
            'last_name' => 'テスト',
            'email' => 'test@example.com',
            'category_id' => $category->id,
        ]);

        $contact = Contact::where('email', 'test@example.com')->first();
        $this->assertTrue($contact->channels->contains($channel1));
        $this->assertTrue($contact->channels->contains($channel2));
    }

    public function test_store_buck()
    {
        $formData = [
            'first_name' => '太郎',
            'last_name' => 'テスト',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel_1' => '080',
            'tel_2' => '1234',
            'tel_3' => '5678',
            'address' => '東京都',
            'building' => 'ビル101',
            'detail' => '修正テスト',
            'category_id' => 1,
            'channel_ids' => [1],
            'image_file' => 'img/sample.jpg',
            'back' => '修正',
        ];

        $response = $this->post('/thanks', $formData);

        $response->assertRedirect('/');
        $response->assertSessionHas('_old_input');
        $response->assertSessionHas('_old_input.first_name', '太郎');
    }

    public function test_admin()
    {
        $user = User::factory()->create();

        $category = Category::create(['content' => 'お問い合わせ']);
        Contact::create([
            'first_name' => '管理',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'admin@example.com',
            'tell' => '09012345678',
            'address' => '東京都',
            'building' => 'ビル101',
            'detail' => '管理者用の問い合わせです',
            'category_id' => $category->id,
            'image_file' => null,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin');

        $response->assertViewHas('contacts');
        $response->assertViewHas('categories');
    }

    public function test_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile');
    }

    public function test_register_profile()
    {
        $user = User::factory()->create();

        $formData = [
            'gender' => 1,
            'position' => '部長',
        ];

        $response = $this->actingAs($user)->post('/admin/register', $formData);

        $response->assertRedirect('/admin');

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'gender' => 1,
            'position' => '部長',
        ]);
    }

    public function test_search()
    {
        $user = User::factory()->create();

        $category = Category::create(['content' => '質問']);

        Contact::create([
            'first_name' => '花子',
            'last_name' => 'テスト',
            'gender' => 2,
            'email' => 'hanako@example.com',
            'tell' => '09012345678',
            'address' => '東京都',
            'building' => 'ビル101',
            'detail' => '検索対象',
            'category_id' => $category->id,
            'image_file' => null,
        ]);

        Contact::create([
            'first_name' => '太郎',
            'last_name' => 'テスト',
            'gender' => 1,
            'email' => 'taro@example.com',
            'tell' => '08012345678',
            'address' => '大阪府',
            'building' => 'ビル102',
            'detail' => 'これは含まれない',
            'category_id' => $category->id,
            'image_file' => null,
        ]);

        $response = $this->actingAs($user)->get('/search?keyword=花子');

        $response->assertStatus(200);
        $response->assertViewIs('admin');

        $contacts = $response->viewData('contacts');
        $this->assertCount(1, $contacts);
        $this->assertEquals('花子', $contacts[0]->first_name);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();

        $category = Category::create(['content' => '削除テスト']);
        $channel = Channel::create(['content' => 'SNS']);

        $contact = Contact::create([
            'first_name' => '削除',
            'last_name' => '対象',
            'gender' => 1,
            'email' => 'delete@example.com',
            'tell' => '09012345678',
            'address' => '東京都',
            'building' => '削除ビル',
            'detail' => '削除対象データ',
            'category_id' => $category->id,
            'image_file' => null,
        ]);
        $contact->channels()->attach($channel->id);

        $response = $this->actingAs($user)->post('/delete', [
            'id' => $contact->id
        ]);

        $response->assertRedirect('/admin');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id
        ]);

        $this->assertDatabaseMissing('channel_contact', [
            'contact_id' => $contact->id
        ]);
    }

    public function test_register_user()
    {
        $formData = [
            'name' => '登録太郎',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $formData);

        $response->assertRedirect('/admin/profile');

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => '登録太郎',
        ]);
    }

    public function test_confirm_validation()
    {
        $response = $this->post('/confirm', []);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel_1',
            'tel_2',
            'tel_3',
            'address',
            'category_id',
            'detail',
        ]);
    }

    public function test_auth()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }
}
