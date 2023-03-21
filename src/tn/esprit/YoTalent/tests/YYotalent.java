/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.tests;

/**
 *
 * @author USER
 */


import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.services.ServiceCategorie;
import tn.esprit.YoTalent.entities.Evenement;
import tn.esprit.YoTalent.services.ServiceEvent;
import tn.esprit.YoTalent.utils.MaConnexion;
import tn.esprit.YoTalent.services.ServiceTicket;
import tn.esprit.YoTalent.entities.Ticket;
 import tn.esprit.YoTalent.entities.Participation;
import tn.esprit.YoTalent.services.ServicePartic;
import tn.esprit.YoTalent.entities.EspaceTalent;
import tn.esprit.YoTalent.services.ServiceET;

import tn.esprit.YoTalent.entities.Video;
import tn.esprit.YoTalent.services.ServiceVideo;



import java.sql.SQLException;
import tn.esprit.YoTalent.entities.Contrat;
import tn.esprit.YoTalent.entities.User;
import tn.esprit.YoTalent.services.ServiceUser;

public class YYotalent {

    public static void main(String[] args) {

    // créer un objet EspaceTalent
    EspaceTalent et = new EspaceTalent("zzz",new User(1),new Video(1),new Categorie(1),new Contrat(1));
    EspaceTalent etm = new EspaceTalent(27,"yyyy",new User(1),new Video(1),new Categorie(1),new Contrat(1));
    EspaceTalent etd = new EspaceTalent(27);
      ServiceET se = new ServiceET();
      
      
      Categorie c = new Categorie("jj");
      ServiceCategorie sc = new ServiceCategorie();
      
      Video v = new Video("iii","..");
      ServiceVideo sv = new ServiceVideo();

    // set other fields of espacetalent object here...

      try {
            
                    se.createOne(et);
//                  se.updateOne(etm);
//                  se.deletOne(etd);
     
         // sc.createOne(c);
             
           System.out.println(se.selectAll());
        } catch (SQLException e) {
            System.out.println(e.getMessage());
        }



    }

}
