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
import com.mycompany.myapp.entities.Voyage;
import com.mycompany.myapp.services.VoyageService;

/**
 *
 * @author MSI GF63
 */
public class modifierVoyage extends Form{
     Form current;
    public modifierVoyage (Resources res,Form previous,Voyage pr){
        setTitle("Modifier  Voyage");
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
        getContentPane().setScrollVisible(false);


        
     

       TextField titre = new TextField("","destination ");
        titre.setUIID("TextFieldBlack");
         TextField dateDvoy = new TextField("","dateDvoy ");
        dateDvoy.setUIID("TextFieldBlack");
        TextField dateRvoy = new TextField("","dateRvoy ");
        dateRvoy.setUIID("TextFieldBlack");
        
        TextField idC = new TextField("","idC");
        idC.setUIID("TextFieldBlack");
    
       


        
       
       Button btnAjouter = new Button("Modifier");
       btnAjouter.addActionListener((e) -> {
            
                try{
                  if(titre.getText()=="" || dateDvoy.getText()==""||dateRvoy.getText()==""||idC.getText()=="")
                   {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Voyage p ;
                      
                        String nom=titre.getText().toString();
                        String date1=dateDvoy.getText().toString();
                        String date2=dateRvoy.getText().toString();
                int idc = Integer.parseInt(idC.getText());

                        p= new Voyage(nom,date1,date2,idc)  ;  
                        p.setIdVoy(pr.getIdVoy());
                    System.out.println("data Auto == "+p );
                    VoyageService.getInstance().ModifierVoyage(p);
                    iDialog.dispose();

                    new ListVoyageForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
              this.add(dateDvoy);

 this.add(dateRvoy);
  this.add(idC);
       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }


    
    

    
}
