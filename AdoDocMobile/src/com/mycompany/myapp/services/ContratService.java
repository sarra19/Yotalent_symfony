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
import com.mycompany.myapp.entities.Contrat;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
/**
 *
 * @author ASMA
 */
public class ContratService {
 Database db;
    public ArrayList<Contrat> contrats;
    public static ContratService instance;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
    
   public ContratService() {
    req = new ConnectionRequest();
}

public static ContratService getInstance() {
    if (instance == null) {
        instance = new ContratService();
    }
    return instance;
}

public boolean AjoutContrat(Contrat p) {
    String url = Statics.BASE_URL + "/contrat/addContratJSON?" + "nomC=" + p.getNomC()+"&"+"DateDC=" + p.getDateDC()+"&"+"DateFC=" + p.getDateFC()+"&"+"idEST=" + p.getIdEST();
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

public ArrayList<Contrat> ListeContrat() {
    String url = Statics.BASE_URL + "/contrat/Allcontrat";
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            try {
               contrats = (ArrayList<Contrat>) parseContrat(new String(req.getResponseData()));
                req.removeResponseListener(this);
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return contrats;
} 

public ArrayList<Contrat> parseContrat(String jsonText) throws IOException {
    ArrayList<Contrat> contrats = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Contrat contrat = new Contrat();
            int id = (int) Float.parseFloat(eventMap.get("idc").toString());
            contrat.setIdC(id);
                        String nomc = eventMap.get("nomc").toString();

            

            
            contrat.setNomC(nomc);

            contrats.add(contrat);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return contrats;
}


public void supprimerContrat(String p) {
    String url = Statics.BASE_URL + "/contrat/deleteContratJSON/" + p;
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
}
  
public boolean ModifierContrat(Contrat p) {
    String url = Statics.BASE_URL + "/contrat/updateContratJSON/" + p.getIdC() + "?nomC=" + p.getNomC()+"&"+"DateDC=" + p.getDateDC()+"&"+"DateFC=" + p.getDateFC()+"&"+"idEST=" + p.getIdEST();
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
