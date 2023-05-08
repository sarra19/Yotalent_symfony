/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import com.codename1.db.Database;
import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author MSI GF63
 */
public class CategorieService {
      Database db;
    public ArrayList<Categorie> categories;
    public static CategorieService instance;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
    
   public CategorieService() {
    req = new ConnectionRequest();
}

public static CategorieService getInstance() {
    if (instance == null) {
        instance = new CategorieService();
    }
    return instance;
}


public boolean AjoutCategorie(Categorie p) {
    String url = Statics.BASE_URL + "/categorie/addCatJSON?"+"nomCat=" + p.getNomCat();
    System.out.print(url);
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            resultOK = req.getResponseCode() == 200; 
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return resultOK;        
}

public ArrayList<Categorie> ListeCategorie() {
    String url = Statics.BASE_URL + "/categorie/AllCategory";
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            try {
                categories = (ArrayList<Categorie>) parseCategory(new String(req.getResponseData()));
                req.removeResponseListener(this);
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return categories;
} 

public ArrayList<Categorie> parseCategory(String jsonText) throws IOException {
    ArrayList<Categorie> categories = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Categorie categorie = new Categorie();
            int id = (int) Float.parseFloat(eventMap.get("idcat").toString());
            categorie.setIdCat(id);

            String nom = eventMap.get("nomcat").toString();
            categorie.setNomCat(nom);

            categories.add(categorie);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return categories;
}

public void supprimerCat(String p) {
    String url = Statics.BASE_URL + "/categorie/deleteCatJSON/" + p;
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
}
  
public boolean ModifierCat(Categorie p) {
    String url = Statics.BASE_URL + "/categorie/updateCatJSON/" + p.getIdCat() + "?nomCat=" + p.getNomCat();
    System.out.print(url);

    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            resultOK = req.getResponseCode() == 200; 
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return resultOK;        
}
}