/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.YoTalent.entities.Evenement;
import tn.esprit.YoTalent.entities.Participation;

import tn.esprit.YoTalent.entities.Ticket;
import tn.esprit.YoTalent.entities.EspaceTalent;

import tn.esprit.YoTalent.utils.MaConnexion;
import java.util.logging.Level;
import java.util.logging.Logger;
import tn.esprit.YoTalent.entities.User;
import tn.esprit.YoTalent.entities.Video;
/**
 *
 * @author USER
 */
public class ServiceET implements IService<EspaceTalent> {

     private Connection cnx;

    public ServiceET(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }

    @Override
    public void createOne(EspaceTalent espaceTalent) throws SQLException {
        String req =   "INSERT INTO `espaceTalent`(`titre`,`idU`,`idVid`,`idCat`,`idC`)" + "VALUES ('"+espaceTalent.getTitre()+"','"+espaceTalent.getIdU()+"','"+espaceTalent.getIdVid()+"','"+espaceTalent.getIdCat()+"','"+espaceTalent.getIdC()+"')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("EspaceTalent ajouté !");
  

        
    }

    @Override
    public void updateOne(EspaceTalent espaceTalent) throws SQLException {
        String sql = "UPDATE espaceTalent SET `idEST`=?,`titre`=?,`idU`=?,``idVid`=?,`idCat`=? ,`idC`=? WHERE idT=" + espaceTalent.getIdEST();
        PreparedStatement ste;
        try {
            ste = cnx.prepareStatement(sql);
    
            ste.setInt(1, espaceTalent.getIdEST());
            ste.setString(2, espaceTalent.getTitre());
            ste.setInt(3, espaceTalent.getIdU());
            ste.setInt(4, espaceTalent.getIdVid());

            ste.setInt(5, espaceTalent.getIdCat());
                      ste.setInt(6, espaceTalent.getIdC());


  

            

            ste.executeUpdate();
            int rowsUpdated = ste.executeUpdate();
            if (rowsUpdated > 0) {
                System.out.println("La modification du ticket :" + espaceTalent.getIdEST() + " a été éffectuée avec succès ");
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceTicket.class.getName()).log(Level.SEVERE, null, ex);
        }
    
    
    }

    @Override
    public void deletOne(EspaceTalent espaceTalentt) throws SQLException {
        try {
            String req = "DELETE FROM espaceTalentt WHERE espaceTalentt.`idEST` = ?";
            PreparedStatement ste = cnx.prepareStatement(req);
            ste.setInt(1, espaceTalentt.getIdEST());
            ste.executeUpdate();
            System.out.println("espaceTalentt supprimé");

        } catch (SQLException ex) {
            Logger.getLogger(ServiceET.class.getName()).log(Level.SEVERE, null, ex);
        }    
    }

    @Override
    public List<EspaceTalent> selectAll() throws SQLException {
          List<EspaceTalent> temp = new ArrayList<>();

        String req = "SELECT * FROM `EspaceTalent`";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            EspaceTalent Cat = new EspaceTalent();

            Cat.setIdEST(rs.getInt(1));
             Cat.setTitre(rs.getString("titre"));
            Cat.setIdU(rs.getInt("idU"));
            Cat.setIdVid(rs.getInt("idVid"));
            Cat.setIdCat(rs.getInt("idCat"));
            Cat.setIdC(rs.getInt("idC"));

            temp.add(Cat);

        }


        return temp;
    }
    

   
    
    
    
}
