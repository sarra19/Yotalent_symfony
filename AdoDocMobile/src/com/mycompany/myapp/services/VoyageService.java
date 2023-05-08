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
import com.mycompany.myapp.entities.Voyage;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author MSI GF63
 */
public class VoyageService {
      Database db;
    public ArrayList<Voyage> voyages;
    public static VoyageService instance;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
    
   public VoyageService() {
    req = new ConnectionRequest();
}

public static VoyageService getInstance() {
    if (instance == null) {
        instance = new VoyageService();
    }
    return instance;
}

public boolean AjoutVoyage(Voyage p) {
    String url = Statics.BASE_URL + "/voyage/addVoyageJSON?" + "dateDvoy=" + p.getDateDvoy()+"&"+"dateRvoy=" + p.getDateDvoy()+"&"+"destination=" + p.getDestination()+"&"+"idC=" + p.getIdC();
   
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

public ArrayList<Voyage> ListeVoyage() {
    String url = Statics.BASE_URL + "/voyage/Allvoyage";
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            try {
               voyages = (ArrayList<Voyage>) parseVoyage(new String(req.getResponseData()));
                req.removeResponseListener(this);
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return voyages;
} 

public ArrayList<Voyage> parseVoyage(String jsonText) throws IOException {
    ArrayList<Voyage> voyages = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Voyage voyage = new Voyage();
            int id = (int) Float.parseFloat(eventMap.get("idvoy").toString());
            voyage.setIdVoy(id);

            String date1 = eventMap.get("datedvoy").toString();
            String date2 = eventMap.get("datedvoy").toString();
                        String nom = eventMap.get("destination").toString();

            voyage.setDateDvoy(date1);
            voyage.setDateRvoy(date2);
            voyage.setDestination(nom);

            voyages.add(voyage);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return voyages;
}

public void supprimerVoyage(String p) {
    String url = Statics.BASE_URL + "/voyage/deleteVoyageJSON/" + p;
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
}
  
public boolean ModifierVoyage(Voyage p) {
    String url = Statics.BASE_URL + "/voyage/updateVoyageJSON/" + p.getIdVoy() + "?dateDVoy=" + p.getDateDvoy()+"&"+"dateRVoy=" + p.getDateRvoy()+"&"+"destination=" + p.getDestination()+"&"+"idC=" + p.getIdC();
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