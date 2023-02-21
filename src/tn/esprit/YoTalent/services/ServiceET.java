/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;


import tn.esprit.YoTalent.entities.Video;
import tn.esprit.YoTalent.entities.EspaceTalent;

import tn.esprit.YoTalent.utils.MaConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.sql.PreparedStatement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;



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
    public void createOne(EspaceTalent espacetalent) throws SQLException {
      String req =   "INSERT INTO `espacetalent`(`titre`,`idU`,`idVid`,`idCat`,`idC`)" + "VALUES ('"+espacetalent.getTitre()+"','"+espacetalent.getIdU()+"','"+espacetalent.getIdVid()+"','"+espacetalent.getIdCat()+"','"+espacetalent.getIdC()+"')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("espacetalent ajouté !");
      
    }
    

    @Override
    public void updateOne(EspaceTalent espacetalent) throws SQLException {
   String req = "UPDATE espacetalent SET `idEST`=?,`titre`=?, `idU`=?, `idVid`=? , `idCat`=? , `idC`=?  WHERE idEST=" + espacetalent.getIdEST();


       
            PreparedStatement pst =cnx.prepareStatement(req);

            pst.setInt(1, espacetalent.getIdEST());
            pst.setString(2, espacetalent.getTitre());
             pst.setInt(3, espacetalent.getIdU());
              pst.setInt(4, espacetalent.getIdVid());
               pst.setInt(5, espacetalent.getIdCat());
                pst.setInt(6, espacetalent.getIdC());
           
            pst.executeUpdate();
            System.out.println("espacetalent " + espacetalent.getTitre() + " is updated successfully");
    }

    @Override
    public void deletOne(EspaceTalent espacetalent) throws SQLException {
try {
            String req = "DELETE FROM espacetalent WHERE espacetalent.`idEST` = ?";
            PreparedStatement ste = cnx.prepareStatement(req);
            ste.setInt(1, espacetalent.getIdEST());
            ste.executeUpdate();
            System.out.println("espace talent  supprimé");

        } catch (SQLException ex) {
            Logger.getLogger(ServiceVideo.class.getName()).log(Level.SEVERE, null, ex);
        }    }


    @Override
    public List<EspaceTalent> selectAll() throws SQLException {
              List<EspaceTalent> temp = new ArrayList<>();

        String req = "SELECT * FROM `espacetalent`";
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
    
    public ObservableList<EspaceTalent> FetchEST()throws SQLException{
       ObservableList<EspaceTalent> espaceTalent = FXCollections.observableArrayList();
        String req = "SELECT * FROM espaceTalent";
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
            
           

            espaceTalent.add(Cat);

        }


        return espaceTalent;
    
    
    }
    }
    
    
    

    

    

