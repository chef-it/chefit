<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class ApiTester
 */
class ApiTester extends TestCase
{
    
    use DatabaseTransactions;

    /**
     * @var \Faker\Generator
     */
    protected $fake;

    /**
     * @var
     */
    protected $token;

    /**
     * @var
     */
    protected $header;

    /**
     * @var
     */
    protected $user;

    /**
     * Append to the url to trigger debuging.
     * Doesn't work.
     * @var string
     */
    protected $debug = '?XDEBUG_SESSION_START=PHPSTORM';

    /**
     * ApiTester constructor.
     * @internal param $faker
     */
    public function __construct()
    {
        $this->fake = Faker\Factory::create();
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->user = $this->getTestingUser();
        $this->token = JWTAuth::fromUser($this->user);
        $this->setTokenHeader();
    }

    /**
     * @return mixed
     */
    public function getTestingUser()
    {
        return \App\User::find(2);
    }


    /**
     * @param $user
     * @return $this
     */
    public function authenticateUser($user)
    {
        $params['email'] = $user->email;
        $params['password'] = 'secret';

        $response = $this->postJson('api/v1/authenticate', $params);

        return $response;
    }

    /**
     *
     */
    public function setTokenHeader()
    {
        $this->header['Authorization'] = 'Bearer ' . $this->token;
    }

    /**
     * @param $uri
     * @return array
     */
    public function getWithToken($uri)
    {
        $this->refreshApplication();
        $request = $this->get($uri, [
            'HTTP_Authorization' => 'Bearer ' . $this->token
        ]);
        $this->assertResponseOk();

        
        return (array) json_decode($request->response->getContent());
    }

    /**
     * @param $uri
     * @return $this
     */
    public function getWithoutToken($uri)
    {
        $this->refreshApplication();
        $request = $this->get($uri);
        $this->assertResponseStatus(500);
        return $request;
    }

    /**
     * @param $uri
     * @return $this
     */
    public function getWithWrongToken($uri)
    {
        $this->refreshApplication();
        $request = $this->get($uri, [
            'HTTP_Authorization' => 'Bearer This_Token_is_Wrong'
        ]);
        $this->assertResponseStatus(400);
        return $request;
    }

    /**
     * @param $uri
     * @param $body
     * @return array
     */
    public function postWithToken($uri, $body)
    {
        $this->refreshApplication();
        $request = $this->post($uri.$this->debug, $body ,[
            'HTTP_Authorization' => 'Bearer ' . $this->token
        ]);
        $this->assertResponseOk();


        return (array) json_decode($request->response->getContent());
    }

    /**
     * @param $uri
     * @return $this
     */
    public function postWithoutToken($uri, $body)
    {
        $this->refreshApplication();
        $request = $this->post($uri, $body);
        $this->assertResponseStatus(500);
        return $request;
    }

    /**
     * @param $uri
     * @return $this
     */
    public function postWithWrongToken($uri, $body)
    {
        $this->refreshApplication();
        $request = $this->post($uri, $body, [
            'HTTP_Authorization' => 'Bearer This_Token_is_Wrong'
        ]);
        $this->assertResponseStatus(400);
        return $request;
    }

    public function checkDatabaseForBody($table, $body)
    {
        reset($body);
        while ($value = current($body)) {
            $this->seeInDatabase($table, array(key($body) => $value));
            next($body);
        }
    }

}
