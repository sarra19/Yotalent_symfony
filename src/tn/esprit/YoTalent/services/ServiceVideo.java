/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;


import tn.esprit.YoTalent.entities.Video;
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
public class ServiceVideo implements IService<Video> {
    private Connection cnx;

    public ServiceVideo(){
        cnx = MaConnexion.getInstance().getCnx();
    }

    @Override
    public void createOne(Video video) throws SQLException {
      String req =   "INSERT INTO `video`(`nomVid`,`url`)" + "VALUES ('"+video.getNomVid()+"','"+video.getUrl()+"')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("Video ajouté !");
      
    }
    

    @Override
    public void updateOne(Video video) throws SQLException {
   String req = "UPDATE video SET `idVid`=?,`nomVid`=?, `url`=? WHERE idVid=" + video.getIdVid();


       
            PreparedStatement pst =cnx.prepareStatement(req);

            pst.setInt(1, video.getIdVid());
            pst.setString(2, video.getNomVid());
             pst.setString(3, video.getUrl());
            
           
            pst.executeUpdate();
            System.out.println("video " + video.getNomVid() + " is updated successfully");
    }

    @Override
    public void deletOne(Video video) throws SQLException {
try {
            String req = "DELETE FROM video WHERE video.`idVid` = ?";
            PreparedStatement ste = cnx.prepareStatement(req);
            ste.setInt(1, video.getIdVid());
            ste.executeUpdate();
            System.out.println("video supprimé");

        } catch (SQLException ex) {
            Logger.getLogger(ServiceVideo.class.getName()).log(Level.SEVERE, null, ex);
        }    }


    @Override
    public List<Video> selectAll() throws SQLException {
              List<Video> temp = new ArrayList<>();

        String req = "SELECT * FROM `Video`";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            Video Cat = new Video();

            Cat.setIdVid(rs.getInt(1));
            Cat.setNomVid(rs.getString("nomVid"));
              Cat.setUrl(rs.getString("url"));
           

            temp.add(Cat);

        }


        return temp;
    }
    
     public ObservableList<Video> FetchVid()throws SQLException{
       ObservableList<Video> video = FXCollections.observableArrayList();
        String req = "SELECT * FROM video";
        PreparedStatement ps = cnx.prepareStatement(req);
        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            Video Cat = new Video();

            Cat.setIdVid(rs.getInt(1));
            Cat.setNomVid(rs.getString("nomVid"));
            Cat.setUrl(rs.getString("url"));
           
            
           

            video.add(Cat);

        }


        return video;
    
    
    }
    }
    
    
    

    

    

