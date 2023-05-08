package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author dhia-
 */
public class StatServiceA {

    public static StatServiceA instance;
    public boolean resultOK;
    private ConnectionRequest req;
    private ArrayList<Stat> stats;

    private StatServiceA() {
        req = new ConnectionRequest();
    }

    public static StatServiceA getInstance() {
        if (instance == null) {
            instance = new StatServiceA();
        }
        return instance;
    }

    public ArrayList<Stat> getStats() {
        String url = Statics.BASE_URL + Statics.CHATRSA;
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    stats = (ArrayList<Stat>) parseStats(new String(req.getResponseData()));
                    req.removeResponseListener(this);
                } catch (IOException ex) {
                    ex.printStackTrace();
                }
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return stats;
    }
    
   public ArrayList<Stat> parseStats(String jsonText) throws IOException {
    ArrayList<Stat> statsResult = new ArrayList<>();

    try {
        JSONParser parser = new JSONParser();
        Map<String, Object> jsonMap = parser.parseJSON(new CharArrayReader(jsonText.toCharArray()));
        List<Map<String, Object>> eventsList = (List<Map<String, Object>>) jsonMap.get("root");
        System.out.println(eventsList);
        for (Map<String, Object> eventMap : eventsList) {
            Stat s = new Stat();
            int value = (int) Float.parseFloat(eventMap.get("value").toString());

            s.setValue(value);

            String label = eventMap.get("label").toString();
            s.setLabel(label);
            System.out.println("label :"+label);
            System.out.println("value :"+value);
            System.out.println("-------");
            

            statsResult.add(s);
        }
    } catch (IOException ex) {
        System.err.println("Error parsing JSON: " + ex.getMessage());
    }

    return statsResult;
}
}