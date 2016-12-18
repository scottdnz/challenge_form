<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Lib\ApiRequester;
use AppBundle\Lib\ServerList;
use AppBundle\Lib\ServerStats;


class ChallengeController extends Controller
{
    
    
    /**
     * @Route("/challenge-form", name="challenge_form")
     * @Method({"GET", "POST"}) 
     */
    public function challengeFormAction()
    {    
        $sl = new ServerList();
        $sl->requestFromApi();
        $sl->setData();
        return $this->render("default/challenge_form.html.twig",
            array("serverList" => $sl->getResponseOutput() )
        );                   
    }
    
    
    /**
     * @Route("/server-api/stats/{serverName}", name="server_api_stats") 
     * @Method({"GET"})
     */
    public function wsServerStatsAction($serverName)
    { 
        $ss = new ServerStats();
        $ss->setServerName($serverName);
        $ss->requestFromApi();
        $ss->setData();
        return $this->json($ss->getResponseOutput());
    }
    
    
    // This is an abandoned route that could be called as a web service
     /**
     * @Route("/server-api/list", name="server_api_list") 
     * @Method({"GET"})
     */
    /*public function wsServerNamesAction()
    {    
        $sl = new ServerList();
        $sl->requestFromApi();
        $sl->setData();
        $resp = new Response($sl->getResponseOutput());
        $resp->headers->set("Content-Type", "text/json");
        $resp->headers->set("Status", "200");
        return $resp;
    }
    */
    
}