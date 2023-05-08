package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.services.CategorieService;


import java.util.ArrayList;

/**
 *
 */
public class ListCatForm extends BaseForm {
    Form current;
    ArrayList<Categorie> l;
    
    public ListCatForm(Resources res) {
        setTitle("Liste des categories");
        setUIID("SignIn");
        current = this;
        super.addSideMenu(res);
        getContentPane().setScrollVisible(false);
        l = CategorieService.getInstance().ListeCategorie();
        
        Button ajout = new Button("Ajouter un nouveau Categorie");
        ajout.addActionListener(b -> {
            AjoutCatForm a = new AjoutCatForm(res, current);
            a.show();
        });
        
      
        
        TextField searchField = new TextField("", "Recherche");
        Button searchButton = new Button("Rechercher");
        searchButton.addActionListener(e -> {
            String searchString = searchField.getText();
            ArrayList<Categorie> searchResults = new ArrayList<>();
            for (Categorie p : l) {
                if (p.getNomCat().contains(searchString)) {
                    searchResults.add(p);
                }
            }
            removeAll();
            add(searchField);
            add(searchButton);
            add(new Label("____________________________________________________________________________________________________________________"));
            add(ajout);
            add(new Label("____________________________________________________________________________________________________________________"));
            for (Categorie p : searchResults) {
                Label id = new Label("ID :" + p.getIdCat());
                Label modele = new Label("nomcat :" + p.getNomCat());
                Button remove = new Button("supprimer");
                remove.addActionListener(evt -> {
                   CategorieService.getInstance().supprimerCat("" + p.getIdCat());
                    ListCatForm a = new ListCatForm(res);
                    a.show();
                });
                Button modifier = new Button("modifier");
                modifier.addActionListener(evt ->{
                    modifierCat h = new modifierCat(res, current, p);
                    h.show();
                });
                add(id);
                add(modele);
                add(modifier);
                add(remove);
                Label separator = new Label("________________________________________________________________________________________________________");
                add(separator);
            }   
        });   
    
        add(searchField);
        add(searchButton);
        add(new Label("____________________________________________________________________________________________________________________"));
        add(ajout);
        add(new Label("____________________________________________________________________________________________________________________"));
        for (Categorie p : l) {
            Label id = new Label("ID :" + p.getIdCat());
            Label modele = new Label("modèle :" + p.getNomCat());
            Button remove = new Button("supprimer");
            remove.addActionListener(evt -> {
                CategorieService.getInstance().supprimerCat("" + p.getIdCat());
                ListCatForm a = new ListCatForm(res);
                a.show();
            });
            Button modifier = new Button("modifier");
            modifier.addActionListener(evt ->{
                modifierCat h = new modifierCat(res, current, p);
                h.show();
            });
            add(id);
            add(modele);
            add(modifier);
            add(remove);
            Label separator = new Label("________________________________________________________________________________________________________");
            add(separator);
        }   
            

    }}