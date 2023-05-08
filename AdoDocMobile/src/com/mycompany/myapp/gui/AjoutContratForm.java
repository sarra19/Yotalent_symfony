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
import com.mycompany.myapp.entities.Contrat;
import com.mycompany.myapp.services.ContratService;
/**
 *
 * @author ASMA
 */
public class AjoutContratForm extends BaseForm {
     Form current;
    public AjoutContratForm(Resources res,Form previous){
        setTitle("Ajout des  Contrat");
        super.addSideMenu(res);
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       
        getContentPane().setScrollVisible(false);

  TextField nomC = new TextField("","nomC");
        nomC.setUIID("TextFieldBlack");
        
        TextField DateDC = new TextField("","DateDC");
        DateDC.setUIID("TextFieldBlack");
         TextField DateFC = new TextField("","DateFC");
        DateFC.setUIID("TextFieldBlack");
         TextField idEST = new TextField("","idEST");
        idEST.setUIID("TextFieldBlack");
        
       
 
        
       
       Button btnAjouter = new Button("Ajouter");
       btnAjouter.addActionListener((e) -> {
             JSONParser parser = new JSONParser();
                try{
                  if((nomC.getText()==""||DateDC.getText()=="" ||DateFC.getText()==""||idEST.getText()=="")) {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else if (nomC.getText().length() < 5) {
        Dialog.show("Veuillez vérifier les données", "entrez au moins 5 caractères.", "OK", null);
    } 
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Contrat p ;
                       // int  nom=titre.getText().toString();
  //int nom = (int) Float.parseFloat(titre.toString());
 // int nom = Integer.parseInt(titre.getText());
    String nomCs=nomC.getText().toString();
    String DateDCs=DateDC.getText().toString();
    String DateFCs=DateFC.getText().toString();
  int idESTs = Integer.parseInt(idEST.getText());

                        p= new Contrat(nomCs,DateDCs,DateFCs,idESTs)  ;      
                    System.out.println("data Auto == "+p );
                    ContratService.getInstance().AjoutContrat(p);
                    iDialog.dispose();

                    new ListContratForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
           this.add(nomC);
           this.add(DateDC);
           this.add(DateFC);
            this.add(idEST);
    
 


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }
    
}
