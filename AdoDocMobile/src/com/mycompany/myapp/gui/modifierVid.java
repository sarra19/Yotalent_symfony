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
import com.mycompany.myapp.entities.Video;
import com.mycompany.myapp.services.VideoService;


/**
 *
 * @author MSI GF63
 */
public class modifierVid extends Form{
     Form current;
    public modifierVid(Resources res,Form previous,Video pr){
        setTitle("Modifier  Video");
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
        getContentPane().setScrollVisible(false);


        
     

       TextField titre = new TextField("","nomVid ");
        titre.setUIID("TextFieldBlack");
       

   TextField titre1 = new TextField("","url");
        titre1.setUIID("TextFieldBlack");
   
           TextField titre2 = new TextField("","idEST");
        titre2.setUIID("TextFieldBlack");
        
       
       Button btnAjouter = new Button("Modifier");
       btnAjouter.addActionListener((e) -> {
            
                try{
                  if(titre.getText()=="" ||titre1.getText()=="" ||titre2.getText()=="" ) {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Video p ;
                      
                            String nom=titre.getText().toString();
                                                String url=titre1.getText().toString();
                                              int idest = Integer.parseInt(titre2.getText().toString());


                        p= new Video(nom,url,idest)  ;      
              
                        p.setIdVid(pr.getIdVid());
                    System.out.println("data Auto == "+p );
                    VideoService.getInstance().ModifierVid(p);
                    iDialog.dispose();

                    new ListVidForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
               this.add(titre1);
       this.add(titre2);


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }


    
    

    
}
