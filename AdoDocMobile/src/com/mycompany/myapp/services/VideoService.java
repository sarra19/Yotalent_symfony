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
import com.mycompany.myapp.entities.Video;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author MSI GF63
 */
public class VideoService {
      Database db;
    public ArrayList<Video> videos;
    public static VideoService instance;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
    
   public VideoService() {
    req = new ConnectionRequest();
}

public static VideoService getInstance() {
    if (instance == null) {
        instance = new VideoService();
    }
    return instance;
}


public boolean AjoutVideo(Video p) {
    String url = Statics.BASE_URL + "/video/addVidJSON?"+"nomVid=" + p.getNomVid()+"&" +"url=" + p.getUrl()+"&" +"idEST=" + p.getIdEST();
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

public ArrayList<Video> ListeVideo() {
    String url = Statics.BASE_URL + "/video/AllVideo";
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            try {
                videos = (ArrayList<Video>) parseVideo(new String(req.getResponseData()));
                req.removeResponseListener(this);
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return videos;
} 

public ArrayList<Video> parseVideo(String jsonText) throws IOException {
    ArrayList<Video> videos = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Video video = new Video();
            int id = (int) Float.parseFloat(eventMap.get("idvid").toString());
            video.setIdVid(id);

            String nom = eventMap.get("nomvid").toString();
            video.setNomVid(nom);
              String url = eventMap.get("url").toString();
            video.setUrl(url);

            videos.add(video);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return videos;
}

public void supprimerVid(String p) {
    String url = Statics.BASE_URL + "/video/deleteVidJSON/" + p;
    req.setUrl(url);
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
}
  
public boolean ModifierVid(Video p) {
    String url = Statics.BASE_URL + "/video/updateVidJSON/" + p.getIdVid() + "?nomVid=" + p.getNomVid()+"&" +"url=" + p.getUrl()+"&" +"idEST=" + p.getIdEST();
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