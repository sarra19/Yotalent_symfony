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

public class YYotalent {

    public static void main(String[] args) {
   //  MaConnexion cn1 = MaConnexion.getInstance();
//        MaConnexion cn2 = MaConnexion.getInstance();
//        MaConnexion cn3 = MaConnexion.getInstance();
//        MaConnexion cn4 = MaConnexion.getInstance();
//
//   //   System.out.println(cn1.hashCode());
//        System.out.println(cn2.hashCode());
//        System.out.println(cn3.hashCode());
//        System.out.println(cn4.hashCode());

       Categorie c = new Categorie("hh");
          ServiceCategorie sc = new ServiceCategorie();
     Categorie f = new Categorie(13,"hh");
      /* Evenement pt = new Evenement(1,"sarra","fhh","gyhgy","ggg");
         ServiceEvent sv = new ServiceEvent();
        */
       
       EspaceTalent et = new EspaceTalent("rrr", 1, 1, 1, 1);
        EspaceTalent ett = new EspaceTalent(15,"rrekj", 1,1,1,1);
                EspaceTalent ettd = new EspaceTalent(15);

         ServiceET se = new ServiceET();
         
           Video ev = new Video( "aaaa","fgg");
            Video evv = new Video(4, "yyy","fgg");
         ServiceVideo sv = new ServiceVideo();
         
        
       
            
 
        try {
            
         /*sv.createOne(pt);
         sv.updateOne(pt);*/
            
    // se.createOne(et);
   //se.updateOne(ett);
                  se.deletOne(ettd);
  
           //   sc.createOne(c);
        // sc.updateOne(f);
          //   sc.deletOne(f);
     
                    
               // sv.createOne(evv);
       // sv.updateOne(evv);
                     //    sv.deletOne(evv);

     
             
            System.out.println(se.selectAll());
        } catch (SQLException e) {
            System.out.println(e.getMessage());
        }


    }

}
