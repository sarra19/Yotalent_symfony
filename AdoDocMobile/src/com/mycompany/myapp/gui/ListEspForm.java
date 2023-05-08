package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Espacetalent;
import com.mycompany.myapp.services.EspaceService;
import java.io.IOException;

import java.util.Collections;

import java.util.ArrayList;

/**
 *
 */
public class ListEspForm extends BaseForm {
    Form current;
    ArrayList<Espacetalent> l;
    
    public ListEspForm(Resources res) {
        setTitle("Liste des espaces");
        setUIID("SignIn");
        current = this;
        super.addSideMenu(res);
        getContentPane().setScrollVisible(false);
        l = EspaceService.getInstance().ListeEspace();
        
           Button ajout1 = new Button("Pdf");
ajout1.addActionListener(e -> {
    try {
        PdfForm pdfForm = new PdfForm(res, current);
        pdfForm.show();
    } catch (IOException ex) {
        ex.printStackTrace();
    }
});
        Button ajout = new Button("Ajouter un nouveau Espace");
        ajout.addActionListener(b -> {
            AjoutEspForm a = new AjoutEspForm(res, current);
            a.show();
        });
        
      
Button ajout2 = new Button("PieChart");
        ajout2.addActionListener(b -> {
            PieChartForm a = new PieChartForm(res, current);
            a.show();
        });
        
        
        Button trier = new Button("Trier par username");

        TextField searchField = new TextField("", "Recherche");
        Button searchButton = new Button("Rechercher");
        searchButton.addActionListener(e -> {
            String searchString = searchField.getText();
            ArrayList<Espacetalent> searchResults = new ArrayList<>();
            for (Espacetalent p : l) {
                if (p.getUsername().contains(searchString)) {
                    searchResults.add(p);
                }
            }
            removeAll();
            add(searchField);
            add(searchButton);
            add(new Label("________________________________________________________________________________________________________________"));
            add(ajout);
                        add(ajout1);
                                        add(ajout2);
                                        add(trier);


            add(new Label("________________________________________________________________________________________________________________"));
            for (Espacetalent p : searchResults) {
               Label id = new Label("idEST :"+p.getIdEST());
           Label nom= new Label("username :"+p.getUsername());
           Label image= new Label("image :"+p.getImage());
            Label nbvotes= new Label("nbVotes :"+p.getNbVotes());
                Button remove = new Button("supprimer");
                remove.addActionListener(evt -> {
                   EspaceService.getInstance().supprimerEsp("" + p.getIdEST());
                    ListEspForm a = new ListEspForm(res);
                    a.show();
                });
                Button modifier = new Button("modifier");
                modifier.addActionListener(evt ->{
                    modifierEsp h = new modifierEsp(res, current, p);
                    h.show();
                });
                add(id);
                add(nom);
                  add(image);
                add(nbvotes);
                add(modifier);
                add(remove);
                Label separator = new Label("____________________________________________________________________________________________________");
                add(separator);
            }   
        });   
    
        add(searchField);
        add(searchButton);
        add(new Label("________________________________________________________________________________________________________________"));
        add(ajout);
        add(ajout1);
                        add(ajout2);
                           add(trier);

        add(new Label("________________________________________________________________________________________________________________"));
        for (Espacetalent p : l) {
           Label id = new Label("idEST :"+p.getIdEST());
           Label nom= new Label("username :"+p.getUsername());
           Label image= new Label("image :"+p.getImage());
            Label nbvotes= new Label("nbVotes :"+p.getNbVotes());
            Button remove = new Button("supprimer");
            remove.addActionListener(evt -> {
                EspaceService.getInstance().supprimerEsp("" + p.getIdEST());
                ListEspForm a = new ListEspForm(res);
                a.show();
            });
            Button modifier = new Button("modifier");
            modifier.addActionListener(evt ->{
                modifierEsp h = new modifierEsp(res, current, p);
                h.show();
            });
            add(id);
                add(nom);
                  add(image);
                add(nbvotes);
                add(modifier);
            add(remove);
            Label separator = new Label("____________________________________________________________________________________________________");
            add(separator);
        }   
            
trier.addActionListener(e -> {
    Collections.sort(l, (c1, c2) -> c1.getUsername().compareTo(c2.getUsername()));
    removeAll();
    add(searchField);
    add(searchButton);
    add(new Label("________________________________________________________________________________________________________________"));
    add(ajout);
    add(ajout1);
                    add(ajout2);

    add(trier);
    add(new Label("________________________________________________________________________________________________________________"));
    for (Espacetalent p : l) {
      Label id = new Label("idEST :"+p.getIdEST());
           Label nom= new Label("username :"+p.getUsername());
           Label image= new Label("image :"+p.getImage());
            Label nbvotes= new Label("nbVotes :"+p.getNbVotes());
        Button remove = new Button("supprimer");
        remove.addActionListener(evt -> {
             EspaceService.getInstance().supprimerEsp("" + p.getIdEST());
                ListEspForm a = new ListEspForm(res);
            a.show();
        });
        Button modifier = new Button("modifier");
        modifier.addActionListener(evt ->{
            modifierEsp h = new modifierEsp(res, current, p);
            h.show();
        });
         add(id);
                add(nom);
                  add(image);
                add(nbvotes);
        add(modifier);
        add(remove);
        Label separator = new Label("____________________________________________________________________________________________________");
        add(separator);
    }
    refreshTheme();
});

    }



}