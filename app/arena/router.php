<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes.php");

$klein = new \Klein\Klein();

$klein->respond("/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "test",
        "path" => $request->pathname(),
        "current" => "test"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/login/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "login",
        "path" => $request->pathname(),
        "current" => "login"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/register/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "register",
        "path" => $request->pathname(),
        "current" => "register"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/challenges/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "challenges",
        "path" => $request->pathname(),
        "current" => "challenges"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/challenges/[:title]-i[:id]/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "challenges-detail",
        "path" => $request->pathname(),
        "current" => "challenges-detail"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/scoreboard/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "scoreboard",
        "path" => $request->pathname(),
        "current" => "scoreboard"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/sponsors/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "sponsors",
        "path" => $request->pathname(),
        "current" => "sponsors"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/resources/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "resources",
        "path" => $request->pathname(),
        "current" => "resources"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/contact-us/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "contact-us",
        "path" => $request->pathname(),
        "current" => "contact-us"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/irc/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "irc",
        "path" => $request->pathname(),
        "current" => "irc"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/user/[:username]/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "user",
        "path" => $request->pathname(),
        "current" => "user"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/team/[:teamId]/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "team",
        "path" => $request->pathname(),
        "current" => "team"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});

$klein->respond("/tests/?",function($request, $response, $service) {
    $response->header("X-PJAX-URL",$request->pathname());
    disableCache($response);
    $data = array(
        'pageTitle' => 'OpenCTF Test Page',
        'viewName' => "test",
        "path" => $request->pathname(),
        "current" => "test"
    );
    if($request->headers()['X-PJAX'])
        $service->layout('views/pjax-wrapper.phtml');
    else
        $service->layout('views/layout-wrapper.phtml');
    $service->render('views/'.$data['viewName'].'.phtml', $data);
});


ob_start();
$klein->dispatch();
echo mini(ob_get_clean());

function disableCache($response){
    $response->header("Cache-Control","no-store, no-cache, must-revalidate, max-age=0");
    $response->header("Pragma","no-cache");
}
function pjaxRedirect($request,$response,$path){
    $response->header("X-PJAX", $request->headers()['X-PJAX']);
    $response->header("X-PJAX-Container", "#pjax-container");
    $response->redirect($path);
}