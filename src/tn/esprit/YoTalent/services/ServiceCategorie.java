/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;


import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.utils.MaConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.sql.PreparedStatement;



/**
 *
 * @author USER
 */
public class ServiceCategorie implements IService<Categorie> {
    private Connection cnx;

    public ServiceCategorie(){
        cnx = MaConnexion.getInstance().getCnx();
    }

    @Override
    public void createOne(Categorie categorie) throws SQLException {
      String req =   "INSERT INTO `categorie`(`nomCat`)" + "VALUES ('"+categorie.getNomCat()+"')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("Categorie ajouté !");
      
    }
    

    @Override
    public void updateOne(Categorie categorie) throws SQLException {
   String req = "UPDATE categorie SET `idCat`=? , `nomCat`=? WHERE idCat=" + categorie.getIdCat();
 
       
            PreparedStatement pst =cnx.prepareStatement(req);

            pst.setInt(1, categorie.getIdCat());
            pst.setString(2, categorie.getNomCat());
            
           
            pst.executeUpdate();
            System.out.println("Categorie " + categorie.getNomCat() + " is updated successfully");
    }

    @Override
    public void deletOne(Categorie categorie) throws SQLException {

        try {
            String req = "DELETE FROM categorie WHERE categorie.`idCat` = ?";
            PreparedStatement ste = cnx.prepareStatement(req);
            ste.setInt(1, categorie.getIdCat());
            ste.executeUpdate();
            System.out.println("categorie supprimé");

        } catch (SQLException ex) {
            Logger.getLogger(ServiceCategorie.class.getName()).log(Level.SEVERE, null, ex);
        }

    
    }
    


    @Override
    public List<Categorie> selectAll() throws SQLException {
              List<Categorie> temp = new ArrayList<>();

        String req = "SELECT * FROM `Categorie`";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            Categorie Cat = new Categorie();

            Cat.setIdCat(rs.getInt(1));
            Cat.setNomCat(rs.getString("nomCat"));
           

            temp.add(Cat);

        }


        return temp;
    }
    }
    
    
    

    

    

