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
import tn.esprit.YoTalent.utils.MaConnexion;
import java.util.logging.Level;
import java.util.logging.Logger;
/**
 *
 * @author USER
 */
public class ServiceTicket implements IService<Ticket> {

     private Connection cnx;

    public ServiceTicket(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }

    @Override
    public void createOne(Ticket ticket) throws SQLException {
        String req =   "INSERT INTO `ticket`(`idT`,`prixT`,`idEv`)" + "VALUES ('"+ticket.getIdT()+"','"+ticket.getPrixT()+"','"+ticket.getIdEv()+"')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("Ticket ajouté !");
    }

    @Override
    public void updateOne(Ticket ticket) throws SQLException {
       String sql = "UPDATE ticket SET `idT`=?,`PrixT`=?,`IdEv`=? WHERE idT=" + ticket.getIdT();
        PreparedStatement ste;
        try {
            ste = cnx.prepareStatement(sql);
            

            ste.setInt(1, ticket.getIdT());

            ste.setInt(2, ticket.getPrixT());
            ste.setInt(3, ticket.getIdEv());

            

  

            

            ste.executeUpdate();
            int rowsUpdated = ste.executeUpdate();
            if (rowsUpdated > 0) {
                System.out.println("La modification du ticket :" + ticket.getIdT() + " a été éffectuée avec succès ");
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceTicket.class.getName()).log(Level.SEVERE, null, ex);
        }
    
    }

    @Override
    public void deletOne(Ticket t) throws SQLException {
    }

    @Override
    public List<Ticket> selectAll() throws SQLException {
          List<Ticket> temp = new ArrayList<>();

        String req = "SELECT * FROM `Ticket`";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            Ticket Cat = new Ticket();

            Cat.setIdT(rs.getInt(1));
            Cat.setPrixT(rs.getInt("prixT"));
            Cat.setPrixT(rs.getInt("idEv"));
           

            temp.add(Cat);

        }


        return temp;
    }
    

   
    
    
    
}
