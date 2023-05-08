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
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.entities.Video;
import com.mycompany.myapp.services.VideoService;


import java.util.ArrayList;

/**
 *
 * @author razi sniha
 */
public class ListVidForm extends BaseForm {
       Form current;
    public ListVidForm(Resources res) {
        
        setTitle("Liste des videos");
        setUIID("SignIn");
         //Toolbar tb = new Toolbar(true);
        current= this;
       // setToolbar(tb);
       super.addSideMenu(res);
        getContentPane().setScrollVisible(false);
        ArrayList<Video> l= new ArrayList<Video>();
        l=VideoService.getInstance().ListeVideo();
        Button ajout = new Button("Add Video");
       
        
        ajout.addActionListener(b->{
        AjoutVidForm a=new AjoutVidForm(res,current);
        a.show();
        });

        add(new Label("______________________________________________________________________________________________________________________"));

        add(ajout);
        add(new Label("______________________________________________________________________________________________________________________"));
        
        for (Video p : l)
        {
           Label id = new Label("idVid :"+p.getIdVid());
           Label nom= new Label("nomVid :"+p.getNomVid());
           Label url= new Label("url :"+p.getUrl());


           Button Video= new Button("Video");
           
           
           add(id);
           add(nom);
              add(url);
             
           

         
    
                 Button remove = new Button("remove");
            System.out.println(p.getIdVid());
                 remove.addActionListener(e->{
               
           VideoService.getInstance().supprimerVid(""+p.getIdVid());
           ListVidForm a = new ListVidForm(res);
           a.show();
           });
           add(remove);
           Button modifier = new Button("modifier");
           modifier.addActionListener(k->{
           modifierVid h = new modifierVid(res,current,p);
           h.show();
           });
           add(modifier);
           Label separator=new Label("__________________________________________________________________________________________________________");
           add(separator);
        }   
    }
}
    


