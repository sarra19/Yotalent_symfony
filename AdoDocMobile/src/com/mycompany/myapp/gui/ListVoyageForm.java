/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Voyage;

import com.mycompany.myapp.services.VoyageService;

import java.util.ArrayList;

/**
 *
 * @author asma glenza
 */
public class ListVoyageForm extends BaseForm {
       Form current;
    public ListVoyageForm(Resources res) {
        
        setTitle("Liste des voyage");
        setUIID("SignIn");
         //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       super.addSideMenu(res);
        getContentPane().setScrollVisible(false);
        ArrayList<Voyage> l= new ArrayList<Voyage>();
        l=VoyageService.getInstance().ListeVoyage();
        Button ajout = new Button("Ajouter un nouveau Voyage");
       Button ajout2 = new Button("PieChart");
        ajout2.addActionListener(b -> {
            PieChartFormA a = new PieChartFormA(res, current);
            a.show();
        });
        
        ajout.addActionListener(b->{
        AjoutVoyageForm a=new AjoutVoyageForm(res,current);
        a.show();
        });

        add(new Label("______________________________________________________________________________________________________________________"));

        add(ajout);
                add(ajout2);

        add(new Label("______________________________________________________________________________________________________________________"));
        
        for (Voyage p : l)
        {
           Label id = new Label("idVoy :"+p.getIdVoy());
            Label date1= new Label("dateDvoy :"+p.getDateDvoy ());
            Label date2= new Label("dateRvoy :"+p.getDateRvoy ());
                       Label nom= new Label("destination :"+p.getDestination ());

           Button Voyage= new Button("Voyage");
           
           
           add(id);
            add(date1);
             add(date2);
           add(nom);

         
    
                 Button remove = new Button("remove");
            System.out.println(p.getIdVoy());
                 remove.addActionListener(e->{
               
           VoyageService.getInstance().supprimerVoyage(""+p.getIdVoy());
           ListVoyageForm a = new ListVoyageForm(res);
           a.show();
           });
           add(remove);
           Button modifier = new Button("modifier");
           modifier.addActionListener(k->{
           modifierVoyage h = new modifierVoyage(res,current,p);
           h.show();
           });
           add(modifier);
           Label separator=new Label("__________________________________________________________________________________________________________");
           add(separator);
        }   
    }
}
    


