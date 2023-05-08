/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.io.JSONParser;
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
import com.mycompany.myapp.entities.Voyage;
import com.mycompany.myapp.services.VoyageService;

/**
 *
 * @author hadir
 */
public class AjoutVoyageForm extends BaseForm {
     Form current;
    public AjoutVoyageForm(Resources res,Form previous){
        setTitle("Ajout des  Voyage");
        super.addSideMenu(res);
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       
        getContentPane().setScrollVisible(false);

  TextField destination = new TextField("","destination");
        destination.setUIID("TextFieldBlack");
        TextField dateDvoy = new TextField("","dateDvoy");
        dateDvoy.setUIID("TextFieldBlack");
         TextField dateRvoy = new TextField("","dateRvoy");
        dateRvoy.setUIID("TextFieldBlack");
         TextField idC = new TextField("","idC");
        idC.setUIID("TextFieldBlack");
    
           
 
        
       
       Button btnAjouter = new Button("Ajouter");
       btnAjouter.addActionListener((e) -> {
             JSONParser parser = new JSONParser();
                try{
                 if(destination.getText()=="" ||dateDvoy.getText()=="" ||dateRvoy.getText()==""||idC.getText()=="")  {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                 else if (destination.getText().length() < 5) {
        Dialog.show("Veuillez vérifier les données", "entrez au moins 5 caractères.", "OK", null);
    } 
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Voyage p ;
                       // int  nom=titre.getText().toString();
  //int nom = (int) Float.parseFloat(titre.toString());
 // int nom = Integer.parseInt(titre.getText());
    String destinations=destination.getText().toString();
    String dateDvoys=dateDvoy.getText().toString();
    String dateRvoys=dateRvoy.getText().toString();
  int idc = Integer.parseInt(idC.getText());

                        p= new Voyage(dateDvoys,dateRvoys,destinations,idc)  ; 
                        
                    System.out.println("data Auto == "+p );
                    VoyageService.getInstance().AjoutVoyage(p);
                    iDialog.dispose();

                    new ListVoyageForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
           this.add(dateDvoy);
           this.add(dateRvoy);
                      this.add(destination);

               this.add(idC);

 


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }
}