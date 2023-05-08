/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.services.CategorieService;


/**
 *
 * @author MSI GF63
 */
public class modifierCat extends Form{
     Form current;
    public modifierCat(Resources res,Form previous,Categorie pr){
        setTitle("Modifier  Category");
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
        getContentPane().setScrollVisible(false);


        
     

       TextField titre = new TextField("","nomCat ");
        titre.setUIID("TextFieldBlack");
       


        
       
       Button btnAjouter = new Button("Modifier");
       btnAjouter.addActionListener((e) -> {
            
                try{
                  if(titre.getText()=="" || titre.getText()=="") {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Categorie p ;
                      
                        String nom=titre.getText().toString();
              
                        p= new Categorie(nom)  ;  
                        p.setIdCat(pr.getIdCat());
                    System.out.println("data Auto == "+p );
                    CategorieService.getInstance().ModifierCat(p);
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
