/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.io.File;
import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.entities.Espacetalent;
import com.mycompany.myapp.services.CategorieService;
import com.mycompany.myapp.services.EspaceService;

/**
 *
 * @author razi
 */
public class AjoutEspForm extends BaseForm {
    Form current;
    public AjoutEspForm(Resources res, Form previous){
        setTitle("Add Space");
        super.addSideMenu(res);
        //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       
        getContentPane().setScrollVisible(false);

        TextField titre = new TextField("","username");
        titre.setUIID("TextFieldBlack");

        Button chooseFileButton = new Button("Choose image");
        TextField selectedFileField = new TextField("", "Selected file:", 20, TextField.UNEDITABLE);
        selectedFileField.setUIID("TextFieldBlack");
       chooseFileButton.addActionListener((e) -> {
    com.codename1.ui.Display.getInstance().openGallery(new ActionListener() {
        @Override
        public void actionPerformed(ActionEvent evt) {
            String selectedFilePath = (String) evt.getSource();
            String fileName = selectedFilePath.substring(selectedFilePath.lastIndexOf("/") + 1);
            selectedFileField.setText(fileName);
        }
    }, com.codename1.ui.Display.GALLERY_IMAGE);
});


        TextField titre2 = new TextField("","nbVotes");
        titre2.setUIID("TextFieldBlack");
        TextField titre3 = new TextField("","idU");
        titre3.setUIID("TextFieldBlack");
        TextField titre4 = new TextField("","idCat");
        titre4.setUIID("TextFieldBlack");

        Button btnAjouter = new Button("Add");
        btnAjouter.addActionListener((e) -> {
            try {
                if(titre.getText().isEmpty() || selectedFileField.getText().isEmpty() || titre2.getText().isEmpty() || titre3.getText().isEmpty() || titre4.getText().isEmpty()) {
                    Dialog.show("Please verify all fields", "", "Cancel", "OK");
                } else if (titre.getText().length() < 5 || selectedFileField.getText().length() < 5) {
                    Dialog.show("Please verify all fields", "Title and image URL must contain at least 5 characters", "OK", null);
                } else if (!titre2.getText().equals("0")) {
                    Dialog.show("Please verify all fields", "Number of votes must be 0", "OK", null);
                } else {
                    InfiniteProgress ip = new InfiniteProgress();
                    final Dialog iDialog = ip.showInfiniteBlocking();

                    Espacetalent p ;
                    String nom=titre.getText().toString();
                    String image=selectedFileField.getText().toString();
                                              int nbvotes = Integer.parseInt(titre2.getText().toString());
                                              int idu = Integer.parseInt(titre3.getText().toString());
                                              int idcat = Integer.parseInt(titre4.getText().toString());


                        p= new Espacetalent(nom,image,nbvotes,idu,idcat)  ;      
                    System.out.println("data Auto == "+p );
                   EspaceService.getInstance().AjoutEspace(p);
                    iDialog.dispose();

                    new ListEspForm(res).show();

                    refreshTheme();
                    }
                }catch (Exception ex){
                    ex.printStackTrace();
                }
       });
       this.add(titre);
                 this.add(selectedFileField);
  this.add(titre2);  this.add(titre3);  this.add(titre4);
  this.add(chooseFileButton);


       this.add(btnAjouter);
       Button back= new Button("Cancel");
               back.addActionListener(l->{
                       previous.show();
               
               });
       this.add(back);
    }
}