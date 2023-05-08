/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.services.CategorieService;

/**
 *
 * @author razi sniha
 */
public class AjoutCatForm extends BaseForm {
     Form current;
    public AjoutCatForm(Resources res,Form previous){
        setTitle("Add Category");
        super.addSideMenu(res);
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       
        getContentPane().setScrollVisible(false);


        TextField titre = new TextField("","nomCat");
        titre.setUIID("TextFieldBlack");
   
 
       
        

       
       Button btnAjouter = new Button("Add");
       btnAjouter.addActionListener((e) -> {
            
           
           
                try{
                  if(titre.getText()=="" ) {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else if (titre.getText().length() < 5) {
        Dialog.show("Veuillez vérifier les données", "Le nom de categorie doit comporter au moins 5 caractères.", "OK", null);
    } 
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Categorie p ;
                        String nom=titre.getText().toString();

                        p= new Categorie(nom)  ;      
                    System.out.println("data Auto == "+p );
                   CategorieService.getInstance().AjoutCategorie(p);
                    iDialog.dispose();

                    new ListCatForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
       


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }
}