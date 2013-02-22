<?php
/**
 * HTML Tag generate class.
 *
 * PHP 5 >= 5.1.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
require_once 'Tag/TagNodes.php';

class Tag_Exception extends Exception {}
class Tag_Base {
  
  protected static $OpenBracket  = '<';
  protected static $CloseBracket = '>';
  protected static $EmptyCloseBracket = '>';
  
  
  /**
   * HTML Document type
   *
   * html5, xhtml, html4
   *
   * @var string $DocType
   */
  public static $DocType='html5';
  
  /**
   * Cache array.
   *
   * self::$DocTypeInstance['html4']
   * self::$DocTypeInstance['xhtml']
   * self::$DocTypeInstance['html5']
   *
   * @var array $DocTypeInstance
   */
  protected static $DocTypeInstance=array();

  /**
   * Current DocType instance.
   *
   * @var Tag_DocType
   */
  protected $doc;
  
  /**
   * The tag property.
   *
   * Matrix:
   * [O]ptional, [F]orbidden, [E]mpty, [D]eprecated
   * and
   * Start Tag{O}, End Tag{O|F}, Empty{E}, Depr.{D}
   *
   * @var array
   */
  protected $property;
  
  /**
   * lowercase always.
   *
   * <$tagName>
   * <$tagName></$tagName>
   *
   * @var string $tagName
   */
  protected $tagName;
  
  /**
   * <$tagName $attributes[key]="$attributes[value]"...>
   *
   * @var array $attributes
   */
  protected $attributes=array();

  /**
   * <$tagName>$nodes</$tagName>
   *
   * $nodes is Tag_Nodes object or a string.
   * Tag_Nodes supported __toString().
   *
   * @var mixed Tag_Nodes or string
   */
  protected $nodes;
  
  /**
   * Tag_Base($tagName, (variadic_options)...)
   *
   * If variadic_options is an array to update attributes.
   *
   * Else if it is a string or a Tag_Base to append nodes.
   *
   * @param string $tagNam
   * @param variadic_options
   */
  public function __construct()
  {
    $args          = func_get_args();
    $this->tagName = strtolower(array_shift($args));
    
    foreach ($args as $arg)
    {
      if (is_array($arg))
        $this->updateAttributes($arg);
      else
        $this->append($arg);
    }
    
    $doc_type_class     = 'Tag_'.ucfirst(self::$DocType);
    $doc_type_file_name = 'Tag'.ucfirst(self::$DocType).'.php';
    require_once dirname(__FILE__).'/'.$doc_type_file_name;
    if (!isset(self::$DocTypeInstance[self::$DocType]))
      self::$DocTypeInstance[self::$DocType] = new $doc_type_class;
    $this->doc      = self::$DocTypeInstance[self::$DocType];
    $this->property = $this->doc->property($this->tagName);
  }
  
  public function __toString()
  {
    $parts = array();
    
    array_push($parts, $this->doc->openTag($this->tagName, $this->attributes));
    if (!$this->doc->isEmptyTag($this->tagName))
    {
      array_push($parts, $this->nodes);
      array_push($parts, $this->doc->closeTag($this->tagName));
    }
    
    return implode('', $parts);
  }
  
  /**
   * Set attribute.
   *
   * If empty $args to return attributes[$name].
   *
   * $attributes[$name] = $args[0]
   *
   * @param $name string
   * @param $args array
   */
  public function __call($name, $args)
  {
    if (empty($args))
      return $this->attributes[$name];
    
    $this->attributes[$name] = $args[0];
    
    return $this;
  }
  
  public function tagName()
  {
    return $this->tagName;
  }
  
  public function append($content)
  {
    if (!$this->nodes)
      $this->nodes = new Tag_Nodes();
    $this->nodes->append($content);
    return $this;
  }
  
  public function attributes()
  {
    return $this->attributes;
  }
  
  public function updateAttributes(array $attributes=array())
  {
    $this->attributes = array_merge(
      $this->attributes,
      $attributes);
    return $this;
  }

  protected static function __create($tagName, $args)
  {
    array_unshift($args, $tagName);
    $_ = new ReflectionClass('Tag_Base');
    return $_->newInstanceArgs($args);
  }
  
  //+generate_here
  public static function a() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function abbr() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function acronym() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function address() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function applet() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function area() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function b() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function base() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function basefont() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function bdo() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function big() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function blockquote() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function body() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function br() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function button() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function caption() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function center() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function cite() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function code() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function col() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function colgroup() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function dd() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function del() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function dfn() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function dir() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function div() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function dl() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function dt() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function em() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function fieldset() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function font() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function form() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function frame() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function frameset() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h1() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h2() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h3() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h4() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h5() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function h6() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function head() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function hr() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function html() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function i() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function iframe() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function img() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function input() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function ins() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function isindex() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function kbd() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function label() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function legend() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function li() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function link() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function map() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function menu() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function meta() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function noframes() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function noscript() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function object() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function ol() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function optgroup() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function option() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function p() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function param() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function pre() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function q() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function s() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function samp() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function script() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function select() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function small() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function span() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function strike() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function strong() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function style() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function sub() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function sup() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function table() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function tbody() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function td() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function textarea() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function tfoot() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function th() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function thead() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function title() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function tr() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function tt() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function u() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function ul() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function article() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function aside() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function audio() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function bdi() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function canvas() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function command() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function data() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function datagrid() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function datalist() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function details() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function embed() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function eventsource() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function figcaption() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function figure() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function footer() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function header() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function hgroup() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function keygen() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function mark() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function meter() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function nav() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function output() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function progress() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function ruby() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function rp() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function rt() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function section() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function source() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function summary() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function time() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function track() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function video() { return self::__create(__FUNCTION__, func_get_args()); }
  public static function wbr() { return self::__create(__FUNCTION__, func_get_args()); }
  //-generate_here
}