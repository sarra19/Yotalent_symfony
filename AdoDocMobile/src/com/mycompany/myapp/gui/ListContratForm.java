package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Contrat;
import com.mycompany.myapp.services.ContratService;
import java.io.IOException;

import java.util.Collections;

import java.util.ArrayList;

/**
 *
 */
public class ListContratForm extends BaseForm {
    Form current;
    ArrayList<Contrat> l;
    
    public ListContratForm(Resources res) {
        setTitle("Liste des contrats");
        setUIID("SignIn");
        current = this;
        super.addSideMenu(res);
        getContentPane().setScrollVisible(false);
        l = ContratService.getInstance().ListeContrat();
        
           Button ajout1 = new Button("Pdf");
ajout1.addActionListener(e -> {
    try {
        PdfFormA pdfFormA = new PdfFormA(res, current);
        pdfFormA.show();
    } catch (IOException ex) {
        ex.printStackTrace();
    }
});
        Button ajout = new Button("Ajouter un nouveau Contrat");
        ajout.addActionListener(b -> {
            AjoutContratForm a = new AjoutContratForm(res, current);
            a.show();
        });
        
      
        
        TextField searchField = new TextField("", "Recherche");
        Button searchButton = new Button("Rechercher");
        searchButton.addActionListener(e -> {
            String searchString = searchField.getText();
            ArrayList<Contrat> searchResults = new ArrayList<>();
            for (Contrat p : l) {
                if (p.getNomC().contains(searchString)) {
                    searchResults.add(p);
                }
            }
            removeAll();
            add(searchField);
            add(searchButton);
            add(new Label("__________________________________________________________________________________________________________________"));
            add(ajout);
                        add(ajout1);

            add(new Label("__________________________________________________________________________________________________________________"));
            for (Contrat p : searchResults) {
                Label id = new Label("ID :" + p.getIdC());
                Label modele = new Label("nomcat :" + p.getNomC());
                Button remove = new Button("supprimer");
                remove.addActionListener(evt -> {
                   ContratService.getInstance().supprimerContrat("" + p.getIdC());
                    ListContratForm a = new ListContratForm(res);
                    a.show();
                });
                Button modifier = new Button("modifier");
                modifier.addActionListener(evt ->{
                    modifierContrat h = new modifierContrat(res, current, p);
                    h.show();
                });
                add(id);
                add(modele);
                add(modifier);
                add(remove);
                Label separator = new Label("______________________________________________________________________________________________________");
                add(separator);
            }   
        });   
    
        add(searchField);
        add(searchButton);
        add(new Label("__________________________________________________________________________________________________________________"));
        add(ajout);
        add(ajout1);
        add(new Label("__________________________________________________________________________________________________________________"));
        for (Contrat p : l) {
            Label id = new Label("ID :" + p.getIdC());
            Label modele = new Label("nomcontart :" + p.getNomC());
            Button remove = new Button("supprimer");
            remove.addActionListener(evt -> {
                ContratService.getInstance().supprimerContrat("" + p.getIdC());
                ListContratForm a = new ListContratForm(res);
                a.show();
            });
            Button modifier = new Button("modifier");
            modifier.addActionListener(evt ->{
                modifierContrat h = new modifierContrat(res, current, p);
                h.show();
            });
            add(id);
            add(modele);
            add(modifier);
            add(remove);
            Label separator = new Label("______________________________________________________________________________________________________");
            add(separator);
        }   
            
Button trier = new Button("Trier par nom");
trier.addActionListener(e -> {
    Collections.sort(l, (c1, c2) -> c1.getNomC().compareTo(c2.getNomC()));
    removeAll();
    add(searchField);
    add(searchButton);
    add(new Label("__________________________________________________________________________________________________________________"));
    add(ajout);
    add(ajout1);
    add(trier);
    add(new Label("__________________________________________________________________________________________________________________"));
    for (Contrat p : l) {
        Label id = new Label("ID :" + p.getIdC());
        Label modele = new Label("modèle :" + p.getNomC());
        Button remove = new Button("supprimer");
        remove.addActionListener(evt -> {
            ContratService.getInstance().supprimerContrat("" + p.getIdC());
            ListContratForm a = new ListContratForm(res);
            a.show();
        });
        Button modifier = new Button("modifier");
        modifier.addActionListener(evt ->{
            modifierContrat h = new modifierContrat(res, current, p);
            h.show();
        });
        add(id);
        add(modele);
        add(modifier);
        add(remove);
        Label separator = new Label("______________________________________________________________________________________________________");
        add(separator);
    }
    refreshTheme();
});
add(trier);

    }



}