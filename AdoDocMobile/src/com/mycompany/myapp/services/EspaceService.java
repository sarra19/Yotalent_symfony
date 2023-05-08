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
import com.mycompany.myapp.entities.Espacetalent;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author MSI GF63
 */
public class EspaceService {
      Database db;
    public ArrayList<Espacetalent> espaces;
    public static EspaceService instance;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
    
   public EspaceService() {
    req = new ConnectionRequest();
}

public static EspaceService getInstance() {
    if (instance == null) {
        instance = new EspaceService();
    }
    return instance;
}


public boolean AjoutEspace(Espacetalent p) {
    String url = Statics.BASE_URL + "/espace/addEstJSON?"+"username=" + p.getUsername()+"&"+"image=" + p.getImage()+"&"+"nbVotes=" + p.getNbVotes()+"&"+"idU=" + p.getIdU()+"&"+"idCat=" + p.getIdCat();
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

public ArrayList<Espacetalent> ListeEspace() {
    String url = Statics.BASE_URL + "/espace/AllEspace";
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            try {
                espaces = (ArrayList<Espacetalent>) parseEspace(new String(req.getResponseData()));
                req.removeResponseListener(this);
                
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return espaces;
    
 

} 

public ArrayList<Espacetalent> parseEspace(String jsonText) throws IOException {
    ArrayList<Espacetalent> espaces = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Espacetalent espacetalent = new Espacetalent();
            int id = (int) Float.parseFloat(eventMap.get("idest").toString());
            espacetalent.setIdEST(id);

            String nom = eventMap.get("username").toString();
            espacetalent.setUsername(nom);
              String image = eventMap.get("image").toString();
            espacetalent.setImage(image);
                int nbvotes = (int) Float.parseFloat(eventMap.get("nbvotes").toString());
            espacetalent.setNbVotes(nbvotes);
  

            espaces.add(espacetalent);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return espaces;
}

public void supprimerEsp(String p) {
    String url = Statics.BASE_URL + "/espace/deleteEspJSON/" + p;
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
}
  
public boolean ModifierEsp(Espacetalent p) {
    String url = Statics.BASE_URL + "/espace/updateEspJSON/" + p.getIdEST() + "?username=" + p.getUsername()+"&"+"image=" + p.getImage()+"&"+"nbVotes=" + p.getNbVotes()+"&"+"idU=" + p.getIdU()+"&"+"idCat=" + p.getIdCat();
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