<?php

namespace FavListEngine;

class FavEngine
{

    public static function setButtonState()
    {
        if(isset($_POST['idPost']))
        {
            $favList = self::favList();
            $postId = $_POST['idPost'];
            if($favList !== false){
                die(array_key_exists($postId, $favList)? 'Remover Favorito' : 'Favoritar'); 
            }else{
                die('Favoritar');
            }
        }
    }

    public function favList()
    {
        if(isset($_COOKIE['list_fav_cookie'])){

            $cookie = $_COOKIE['list_fav_cookie'];
            $cookie = stripslashes($cookie);
            return json_decode($cookie, true);
        
        }else{
            return false;
        }
    }

    public static function addFavButton( $content ) {    
        if( is_single() ) {
            $postId = get_the_ID();
            $btnFav = "<button value='{$postId}' id='favBtn' type='button' class='favBtn' name='btnFav' id='btnFav'>Button</button>"; 
            $content .= $btnFav;
        }
        return $content;
    }

    public static function managerFavoriteList() {

        if(!isset($_POST['idPost'])) return 0;

        $value = $_POST['idPost'];
        $favList = self::favList();

        if($favList !== false){

            if(array_key_exists($value, $favList)){
                unset($favList[$value]);
                $retorno = 'Favoritar';
            }else{
                $name = get_the_title( $value );
                $link = get_permalink( $value );
                $favList[$value] = array($name, $link);
                $retorno = 'Remover Favorito';
            }

        }else{
            
            $name = get_the_title( $value );
            $link = get_permalink( $value );
            $favList = array();
            $favList[$value] = array($name, $link);
            $retorno = 'Remover Favorito';

        }

        $encode = json_encode($favList);
        setcookie( 'list_fav_cookie', null, - 1 );
        setcookie( 'list_fav_cookie', $encode, time() + 3600 );

        die($retorno);


    }

    public static function generateFavoriteList()
    {
        if(!isset($_COOKIE['list_fav_cookie'])) return 0;

        $cookie = $_COOKIE['list_fav_cookie'];
        $cookie = stripslashes($cookie);

        die($cookie);
    }

    public static function generateShortcode()
    {
        $favList = self::favList();
        echo '<ul id="fav_list_shortcode">';
        foreach ( $favList as $favorite ) {
            echo "<li><a href='{$favorite[1]}'>{$favorite[0]}</li>";
        }
        echo "</ul>";
    }

}