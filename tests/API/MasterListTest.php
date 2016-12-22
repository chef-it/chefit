<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\MasterList;

/**
 * Class MasterListTest
 */
class MasterListTest extends ApiTester
{

    use DatabaseTransactions;

    /** @test */
    public function user_can_log_in()
    {
        $user = $this->getTestingUser();

        $request = $this->authenticateUser($user);
        $this->assertResponseOk();

        $response = json_decode($request->response->getContent());
        $this->token = $response->token;
        $this->assertNotNull($this->token);
    }

    /** @test */
    public function master_list_entries_are_returned_to_user()
    {
        $content = $this->getWithToken('api/v1/masterlist');

        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('currencySymbol', $content);
    }

    /** @test */
    public function no_masterlist_entries_are_returned_when_there_are_token_issues()
    {
        $this->getWithoutToken('api/v1/masterlist');
        $this->getWithWrongToken('api/v1/masterlist');
    }

    /** @test */
    public function a_new_masterlist_record_is_stored()
    {
        $body = $this->makeBodyFromMasterList();

        $this->postWithToken('api/v1/masterlist', $body);

        $body[yield] /= 100;

        $this->checkDatabaseForBody('master_list', $body);
    }

    /** @test */
    public function make_sure_a_bad_body_isnt_stored()
    {
        $body = $this->makeBodyFromMasterlist(['price' => 'treefiddy']);
        $this->postWithToken('api/v1/masterlist', $body);
    }

    /** @test */
    public function no_masterlist_record_is_stored_when_there_are_token_issues()
    {
        $body = $this->makeBodyFromMasterlist();

        $this->postWithoutToken('api/v1/masterlist', $body);
        $this->postWithWrongToken('api/v1/masterlist', $body);

        $this->dontSeeInDatabase('master_list', array('name' => $body['name']));
    }

    /** @test */
    public function user_receives_information_to_populate_form_for_editing_a_masterlist_record()
    {

    }

    /**
     * @param array $overrides
     * @return mixed
     */
    public function makeMasterList($overrides = [])
    {
        return factory(MasterList::class)->make($overrides);
    }

    public function makeBodyFromMasterlist($overrides = [])
    {
        return $this->makeMasterList($overrides)->toArray();
    }

}
