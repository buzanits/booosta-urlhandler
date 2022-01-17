<?php
namespace booosta\urlhandler;

\booosta\Framework::add_module_trait('webapp', 'urlhandler\webapp');

trait webapp
{
  protected $urlhandler_paramlist;
  protected $urlhandler_action_paramlist;

  protected function webappinit_urlhandler()
  {
    #\booosta\debug($_SERVER);
    $this->script_extension = '';   // override '.php'
    $this->script_actionstr = '/';
    $this->script_divider = '/';

    $this->self_raw = $this->self;

    if(strstr($this->self, 'vendor/booosta/urlhandler/src/urlhandler_proxy.php')): 
      $self = trim($_SERVER['REQUEST_URI'], '/');
      list($this->self, $dummy) = explode('/', $self);
    endif;

    $this->self = str_replace('.php', '', $this->self);

    $this->phpself_raw = $this->phpself;
    $this->phpself = str_replace('.php', '', $this->phpself);

    $this->subtable_params = '/subtables/';
    $this->edit_params = '/edit/';
    $this->delete_params = '/delete/';
    $this->deleteyes_params = '/deleteyes/';
    $this->new_params = '/new/';

    if($getparams = $this->VAR['urlhandler_getparams']):
      #\booosta\debug("getparams: $getparams");

      $getparams = trim($getparams, '/');
      $params = explode('/', $getparams);

      if(is_array($this->urlhandler_action_paramlist)):  // different params for different actions
        $action = $params[0];
        $plist = $this->urlhandler_action_paramlist[$action];
      endif;

      if($plist == null) $plist = $this->urlhandler_paramlist;

      if($plist):
        // implement individual paramlist
        $plist = trim($plist, '/');
        $param_names = explode('/', $plist);

        $new_params = $this->array_combine($param_names, $params);
        $this->VAR = array_merge($this->VAR, $new_params);

        if($this->VAR['action']) $this->action = $this->VAR['action'];
        if($this->VAR['object_id']) $this->id = intval($this->VAR['object_id']);;
      else:
        if($this->VAR['action'] == '') $this->action = $this->VAR['action'] = $params[0];
        if($this->VAR['object_id'] == '') $this->id = $this->VAR['object_id'] = intval($params[1]);;
      endif;

      unset($this->VAR['urlhandler_getparams']);
    endif;

    $this->TPL['html_head'] .= "<base href='/'>";
    #\booosta\debug('$this->VAR:'); \booosta\debug($this->VAR);
  }
}
