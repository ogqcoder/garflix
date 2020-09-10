<?php

class FormSanitizer {

  public static function sanitizeFormString($p) {

        $p = strip_tags($p); //removes tags
        $p = str_replace(" ", "", $p);
        $p = trim($p); // rmoves all spaces beforw and after
        $p = strtolower($p); //lower cases all characters
        $p = ucfirst($p); // uppercases first character
        return $p; //give it back now

      }

  public static function sanitizeFormUsername($p) {

        $p = strip_tags($p); //removes tags
        $p = str_replace(" ", "", $p);
        return $p; //give it back now

      }

  public static function sanitizeFormPassword($p) {

        $p = strip_tags($p); //removes tags
        return $p; //give it back now

      }
  public static function sanitizeFormEmail($p) {

        $p = strip_tags($p); //removes tags
        $p = str_replace(" ", "", $p);
        return $p; //give it back now

      }


}
 ?>
