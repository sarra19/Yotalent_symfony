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
import com.mycompany.myapp.entities.Contrat;
import com.mycompany.myapp.services.ContratService;
/**
 *
 * @author ASMA
 */
public class modifierContrat extends Form{
    
     Form current;
    public modifierContrat (Resources res,Form previous,Contrat pr){
        setTitle("Modifier  Contrat");
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
        getContentPane().setScrollVisible(false);


        
     

       TextField titre = new TextField("","nomC ");
        titre.setUIID("TextFieldBlack");
        TextField DateDC = new TextField("","DateDC ");
        DateDC.setUIID("TextFieldBlack");
        TextField DateFC = new TextField("","DateFC ");
        DateFC.setUIID("TextFieldBlack");
        
        TextField idEST = new TextField("","idEST");
        idEST.setUIID("TextFieldBlack");
       


        
       
       Button btnAjouter = new Button("Modifier");
       btnAjouter.addActionListener((e) -> {
            
                try{
                  if(titre.getText()=="" || DateDC.getText()==""||DateFC.getText()==""||idEST.getText()=="") {
                    Dialog.show("Veuillez vérifier les données","","Annuler","OK");
                  }
                  else{
                        InfiniteProgress ip = new InfiniteProgress();;
                        final Dialog iDialog = ip.showInfiniteBlocking();
                        Contrat p ;
                      
                        String nom=titre.getText().toString();
                        String date1=DateDC.getText().toString();
                        String date2=DateFC.getText().toString();
                        int idest = Integer.parseInt(idEST.getText());
              
                        p= new Contrat(nom,date1,date2,idest)  ;  
                        p.setIdC(pr.getIdC());
                    System.out.println("data Auto == "+p );
                    ContratService.getInstance().ModifierContrat(p);
                    iDialog.dispose();

                    new ListContratForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
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
