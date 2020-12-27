<?php


namespace App\Models;


class MenuModel
{
    public function getMenuLinks(){
         $links = \DB::table("menu_links AS ml")
                ->leftJoin("footer_headline AS fh","footer_headline_id","fh.id")
                ->select("ml.id AS menu_id", "ml.text","ml.href", "ml.parent_id", "in_footer", "in_header", "ml.footer_headline_id", "fh.*")
                ->where([
                    ["ml.admin_link",0],
                    ["ml.is_deleted",0]
                ])
                ->get();

         foreach($links as $link) {
            $link->childrenLinks = \DB::table("menu_links AS ml")
                                    ->leftJoin("footer_headline AS fh","footer_headline_id","fh.id")
                                    ->where("parent_id","=",$link->menu_id)
                                    ->select("ml.id AS menu_id", "ml.text","ml.href", "ml.parent_id", "in_footer", "in_header", "ml.footer_headline_id", "fh.*")
                                    ->get();
        }
        return $links;
   }

   //ADMIN

    public function deleteLink($id){
        return \DB::table("menu_links")
            ->where("id", $id)
            ->update([
                "is_deleted" => 1
            ]);
    }

    public function insertLink($text,$path, $parent, $header, $footer, $admin){
        return \DB::table("menu_links")
            ->insertGetId([
                "id" => NULL,
                "text" => $text,
                "href" => $path,
                "in_header" => $header,
                "in_footer" => $footer,
                "parent_id" => $parent,
                "admin_link" => $admin,
                "inserted_at" => date("Y-m-d H:i:s"),
                "updated_at" => NULL,
                "is_deleted" => 0
            ]);
    }

    public function updateLink($id, $text,$path, $parent, $header, $footer, $admin){
        return \DB::table("menu_links")
            ->where("id", $id)
            ->update([
                "text" => $text,
                "href" => $path,
                "in_header" => $header,
                "in_footer" => $footer,
                "parent_id" => $parent,
                "admin_link" => $admin
            ]);
    }

    public function getMenuLinksAdmin(){
        return \DB::table("menu_links AS ml")
            ->select("ml.id AS menu_id", "ml.text","ml.href")
            ->where([
                ["ml.admin_link",1],
                ["ml.is_deleted",0]
            ])
            ->get();
    }

    public function getAllLinks(){
        return \DB::table("menu_links AS ml")
            ->select("ml.id AS menu_id", "ml.text","ml.href","ml.in_footer","ml.in_header","ml.admin_link")
            ->where([
                ["ml.is_deleted",0]
            ])
            ->get();
    }

    public function getLinkData($id){
        return \DB::table("menu_links AS ml")
            ->leftJoin("menu_links AS ml1", "ml.parent_id", "ml1.id")
            ->select("ml.id AS menu_id", "ml.text","ml.href","ml.in_footer","ml.in_header","ml.admin_link","ml1.id AS idParent","ml1.text AS textParent")
            ->where([
                ["ml.id",$id]
            ])
            ->get();
    }


}
