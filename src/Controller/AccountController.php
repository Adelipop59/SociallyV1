<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class AccountController extends AbstractController
{
    #[Route('/account/connexion', name: 'app_account_connexion')]
    public function index(): Response
    {
        $user = new User();
        // ...

        $form = $this->createForm(UserType::class, $user);

        var_dump($_GET);
        $idApp = '479384990937418';
        $cleApp = '115f5959ee844574ec70d10c1bd00a37';

        if(isset($_GET['code']) == true ){
            var_dump('code recu');
            $code = $_GET['code'];
            /*
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', 'https://graph.facebook.com/v15.0/oauth/access_token', 
            [
            'query' => [
                    'client_id' => '479384990937418',
                    'redirect_uri' => 'https://www.localhost:8000/account/connexion',
                    'client_secret' => '115f5959ee844574ec70d10c1bd00a37',
                    'code' => '',
                ]
            ]);
            */
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://graph.facebook.com/v15.0/oauth/access_token?client_id=479384990937418&redirect_uri=https://www.localhost:8000/account/connexion&client_secret=115f5959ee844574ec70d10c1bd00a37&code='.$code);

            echo $response->getStatusCode();
            echo $response->getBody();            
            print_r($response);
        }else{
            var_dump('code non recu');
        }

        

        return $this->render('login.html.twig', [
            'form' => $this->createForm(UserType::class, (new User()))->createView(),
            'data' => $_POST           ,
        ]);
    }

    #[Route('/account/connexionCo', name: 'co_connection')]
    public function Coco()
    {
        print_r($_POST);
        return $this->redirect('https://www.facebook.com/v15.0/dialog/oauth?client_id=479384990937418&redirect_uri=https://www.localhost:8000/account/connexion&state={st=state123abc,ds=123456789}');
        return $this->json($_POST);
    }

    #[Route('/login', name: 'login')]
    public function Login(): Response
    {
        return $this->render('login.html.twig', [
            'form' => $this->createForm(UserType::class, (new User()))->createView(),
        ]);
    }
}