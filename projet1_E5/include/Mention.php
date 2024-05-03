<?php

class Mention {
    public static function calculerMention($notes) {
        if ($notes > 16) {
            return "Admis - mention TB";
        } elseif ($notes >= 14) {
            return "Admis - mention B";
        } elseif ($notes >= 12) {
            return "Admis - mention AB";
        } elseif ($notes >= 10) {
            return "Admis - pas de mention";
        } else {
            return "Recalé";
        }
    }
}
?>
