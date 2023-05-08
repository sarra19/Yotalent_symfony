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
import com.mycompany.myapp.entities.Espacetalent;
import com.mycompany.myapp.services.EspaceService;


/**
 *
 * @author MSI GF63
 */
public class modifierEsp extends Form{
     Form current;
    public modifierEsp(Resources res,Form previous,Espacetalent pr){
        setTitle("Modifier  Espacetalent");
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
        getContentPane().setScrollVisible(false);


        
     

       TextField titre = new TextField("","username ");
        titre.setUIID("TextFieldBlack");
       

   TextField titre1 = new TextField("","image");
        titre1.setUIID("TextFieldBlack");
   
           TextField titre2 = new TextField("","nbVotes");
        titre2.setUIID("TextFieldBlack");
              TextField titre3 = new TextField("","idU");
        titre3.setUIID("TextFieldBlack");
            TextField titre4 = new TextField("","idCat");
        titre4.setUIID("TextFieldBlack");
        
       
       Button btnAjouter = new Button("Modifier");
       btnAjouter.addActionListener((e) -> {
            
                try{
                  if(titre.getText()=="" ||titre1.getText()=="" ||titre2.getText()=="" ||titre3.getText()=="" ||titre4.getText()=="" ) {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Espacetalent p ;
                      
                            String nom=titre.getText().toString();
                                                String image=titre1.getText().toString();
                                              int nbvote = Integer.parseInt(titre2.getText().toString());
                                              int idu = Integer.parseInt(titre3.getText().toString());
                                              int idcat = Integer.parseInt(titre4.getText().toString());


                        p= new Espacetalent(nom,image,nbvote,idu,idcat)  ;      
              
                        p.setIdEST(pr.getIdEST());
                    System.out.println("data Auto == "+p );
                    EspaceService.getInstance().ModifierEsp(p);
                    iDialog.dispose();

                    new ListEspForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
               this.add(titre1);
       this.add(titre2);
 this.add(titre3);
 this.add(titre4);


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }


    
    

    
}
